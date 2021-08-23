<?php

namespace Leeto\Admin\Traits;

use App\Models\OrderProduct;
use Leeto\Admin\Components\Fields\FileInterface;
use Leeto\Admin\Components\Fields\HasMany;
use Leeto\Admin\Components\Fields\Line;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Leeto\Admin\Components\Fields\SlideField;
use Leeto\Admin\Components\Fields\SubItemInterface;
use Leeto\Admin\Components\RelationInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Trait ControllerTrait
 * @package Leeto\Admin\Traits
 */
trait ControllerTrait {
    /* @var \Leeto\Admin\Resources\Resource */
    protected $resource;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        if(request()->has("_export")) {
            return $this->_export();
        }
        return view($this->resource->baseIndexView, [
            "resource" => $this->resource,
        ]);
    }

    protected function _export() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $letter = "A";
        foreach ($this->resource->exportFields() as $index => $field) {
            $sheet->setCellValue($letter.'1', $this->resource->label($field));

            $letter++;
        }

        $sheet->getStyle('A1:'.$letter.'1')->getFont()->setBold(true);


        $line = 2;
        foreach ($this->resource->all() as $item) {
            $letter = "A";
            foreach ($this->resource->exportFields() as $index => $field) {
                $sheet->setCellValue($letter . $line, $this->resource->exportValue($item, $field));
                $letter++;
            }

            $line++;
        }


        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$this->resource->title.'.xlsx"');
        header('Cache-Control: max-age=0');

        return response($writer->save('php://output'));
    }

    /**
     * @param null $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function _view_edit($item = null) {
        return view($this->resource->baseEditView, [
            "resource" =>  $this->resource,
            "item" => $item ? $item : $this->resource->getModel(),
        ]);
    }

    /**
     * @param Request $request
     * @param Model $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function _save(Request $request, Model $item) {
        if($request->isMethod('post') || $request->isMethod('put')) {
            Validator::make($request->all(), $this->resource->rules($item), $this->resource->messages(), $this->resource->attributes())->validate();

            $data = [];
            $fields = $this->resource->getFields();

            /* @var \Leeto\Admin\Components\Fields\Field $field */
            foreach ($fields as $field) {
                $value = $field->save();

                if($value !== false) {
                    if($field instanceof Line) {
                        $data[$field->name()] = $field->formatValues($value);
                    } elseif($field instanceof FileInterface && $field->multiple) {
                        $data[$field->name()] = $field->sync($value);
                    } else {
                        $data[$field->name()] = $value;
                    }
                }
            }

            $item->fill($data);

            if($item->save()) {
                foreach ($fields as $field) {
                    if($field instanceof RelationInterface && (new \ReflectionClass($item->{$field->relation()}()))->getShortName() == "BelongsToMany") {
                        $value = $field->save();
                        $item->{$field->relation()}()->sync(is_array($value) ? $value : []);
                    } elseif($field instanceof SubItemInterface && (new \ReflectionClass($item->{$field->relation()}()))->getShortName() == "HasMany") {
                        if($value = $field->save()) {
                            $item->{$field->relation()}()->delete();

                            $value = collect($value)->map(function ($v) use($field, $item) {
                                $relatedClass = $item->{$field->relation()}()->getRelated();
                                
                                $newItem = new $relatedClass($v);
                                $newItem->{$item->{$field->relation()}()->getForeignKeyName()} = $item->id;
                                $newItem->save();

                                if($subFields = $field->getSubFields()) {
                                    foreach ($subFields as $subField) {
                                        $newItem->{$subField->relation()}()->delete();
                                        $subRelatedClass = $newItem->{$subField->relation()}()->getRelated();

                                        if(isset($v[$subField->relation()])) {
                                            foreach ($v[$subField->relation()] as $vv) {
                                                $newSubItem = new $subRelatedClass($vv);
                                                $newSubItem->{$newItem->{$subField->relation()}()->getForeignKeyName()} = $newItem->id;
                                                $newSubItem->save();

                                                $newItem->{$subField->relation()}()->save($newSubItem);
                                            }
                                        }
                                    }
                                }

                                return $newItem;
                            });

                            $item->{$field->relation()}()->saveMany($value);
                        }
                    } elseif($field instanceof SlideField) {
                        $item->{$field->minName} = request($field->minName);
                        $item->{$field->maxName} = request($field->maxName);
                    } elseif($field instanceof FileInterface && $field->multiple) {
                        $item->{$field->name()} = $field->sync($item->{$field->name()}, true);
                    }
                }

                $item->save();
            }

            return redirect($this->resource->route("index"))->with("alert", __("admin.saved"));
        }

        return $this->_view_edit($item);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        if(!in_array("add", $this->resource->actions)) {
            return redirect($this->resource->route("index"));
        }

        return $this->_view_edit();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        if(!in_array("edit", $this->resource->actions)) {
            return redirect($this->resource->route("index"));
        }

        $item = $this->resource->getModel()->where(["id" => $id])->firstOrFail();

        $this->resource->setItem($item);

        return $this->_view_edit($item);
    }

    public function show($id) {
        return redirect($this->resource->route("index"));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request) {
        if(!in_array("edit", $this->resource->actions)) {
            return redirect($this->resource->route("index"));
        }

        $item = $this->resource->getModel()->where(["id" => $id])->firstOrFail();

        return $this->_save($request, $item);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        if(!in_array("edit", $this->resource->actions) && !in_array("add", $this->resource->actions)) {
            return redirect($this->resource->route("index"));
        }

        $item = $this->resource->getModel();

        return $this->_save($request, $item);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        if(!in_array("delete", $this->resource->actions)) {
            return redirect($this->resource->route("index"));
        }

        if(request()->has("ids")) {
            $this->resource->getModel()->whereIn("id", explode(";", request("ids")))->delete();
        } else {
            $this->resource->getModel()->destroy($id);
        }

        return redirect($this->resource->route("index"))->with("alert", __("admin.deleted"));
    }
}