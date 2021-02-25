<?php

namespace Leeto\Admin\Resources;

use Leeto\Admin\Components\Decorations\Tab;
use Leeto\Admin\Components\Fields\Date;
use Leeto\Admin\Components\Fields\Field;
use Leeto\Admin\Components\Fields\File;
use Leeto\Admin\Components\Fields\HasMany;
use Leeto\Admin\Components\Fields\HasOne;
use Leeto\Admin\Components\Fields\Image;
use Leeto\Admin\Components\Fields\Line;
use Leeto\Admin\Components\Fields\Number;
use Leeto\Admin\Components\Fields\SlideField;
use Leeto\Admin\Components\Fields\SubItemInterface;
use Leeto\Admin\Components\Fields\SwitchField;
use Leeto\Admin\Components\Filters\Filter;
use Leeto\Admin\Components\Filters\HasManyFilter;
use Leeto\Admin\Components\Filters\HasOneFilter;
use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Components\ViewComponent;
use Leeto\Admin\Traits\Resources\RouteTrait;
use Leeto\Admin\Traits\Resources\QueryTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resource
 * @package Leeto\Admin\Resources
 */
abstract class Resource implements ResourceInterface
{
    use QueryTrait, RouteTrait;

    /**
     * @var
     */
    public static $model;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $subtitle;

    /**
     * @var
     */
    public $actions = ["add", "edit", "delete"];

    /**
     * @var null
     */
    public $defaultSortField = null;

    /**
     * @var string
     */
    public $defaultSortType = "DESC";

    /**
     * @var int
     */
    public $itemsPerPage = 5;


    public $baseIndexView = "admin::base.index";

    public $baseEditView = "admin::base.edit";

    public $item;

    public $subItemData;

    /**
     * @return array
     */
    abstract function attributes();

    /**
     * @param $item
     * @return array
     */
    abstract function rules($item);

    /**
     * @return Field[]
     */
    abstract function fields();

    /**
     * @return array
     */
    abstract function search();

    /**
     * @return Filter[]
     */
    abstract function filters();

    /**
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item): void
    {
        $this->item = $item;

        $this->setSubItemData();
    }

    /**
     * @return mixed
     */
    public function getSubItemData()
    {
        return $this->subItemData;
    }

    public function setSubItemData(): void
    {
        foreach ($this->getFields() as $field) {
            if($field instanceof SubItemInterface) {
                $this->subItemData[$field->relation()] = $this->getItem()->{$field->relation()};

                if($field->getFields()) {
                    foreach ($field->getFields() as $subField) {
                        if($subField instanceof SubItemInterface) {
                            foreach ($this->getItem()->{$field->relation()} as $data) {
                                $this->subItemData[$field->relation() . "." . $subField->relation()][$data->id] = $data->{$subField->relation()};
                            }
                        }
                    }
                }
            }
        }
    }

    /**
    * @return array
    */
    public function getFields() {
        $fields = [];

        foreach ($this->fields() as $item) {
            if($item instanceof Field) {
                $fields[] = $item;
            } elseif($item instanceof Tab) {
                foreach ($item->getFields() as $field) {
                    if($field instanceof Field) {
                        $fields[] = $field;
                    }
                }
            }
        }

        return $fields;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function formTabs() {
        return collect($this->fields())->filter(function ($item) {
           return $item instanceof Tab;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function formFields() {
        $fields = collect();

        if(app("AdminExtensions")) {
            foreach (app("AdminExtensions") as $extension) {
                $extensionFields = collect($extension->formFields())->filter(function ($value) {
                    return $value->form;
                });

                $fields = $fields->merge($extensionFields);
            }
        }

        $fields = $fields->merge(collect($this->fields())->filter(function ($value) {
            return $value instanceof Field && $value->form;
        }));

        return $fields;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function whenFields() {
        return collect($this->getFields())->filter(function ($value) {
            return $value->showWhenState;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function whenFieldNames() {
        $names = [];

        foreach ($this->whenFields() as $field) {
            $names[$field->showWhenField] = $field->showWhenField;
        }

        return collect($names);
    }

    public function isWhenConditionField($name) {
        return $this->whenFieldNames()->has($name);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function indexFields() {
        return collect($this->getFields())->filter(function ($value) {
            return $value->index;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportFields() {
        return collect($this->getFields())->filter(function ($value) {
            return $value->export;
        });
    }

    /**
     * @param $type
     * @return array|mixed
     */
    public function getAssets($type) {
        $assets = [];

        foreach ($this->getFields() as $field) {
            if($field->getAssets()) {
                $assets = array_merge($field->getAssets(), $assets);
            }
        }

        return $assets[$type] ?? [];
    }

    /**
     * @return string
     */
    public function getModelName() : string {
        return static::$model;
    }

    /**
     * @return Model
     */
    public function getModel() : Model {
        $model = static::$model;

        return new $model;
    }

    /**
     * @param $name
     * @return \Illuminate\Support\Collection
     */
    public function getFilter($name) {

        return collect($this->filters())->filter(function ($value) use($name) {
            /* @var \Leeto\Admin\Components\Filters\Filter $value */
            return $value->name() == $name;
        })->first();
    }

    /**
     * @param $name
     * @return \Illuminate\Support\Collection
     */
    public function getField($name) {

        return collect($this->getFields())->filter(function ($value) use($name) {
            /* @var \Leeto\Admin\Components\Fields\Field $value */
            return $value->name() == $name;
        })->first();
    }

    /**
     * @param ViewComponent $field
     * @return string
     */
    public function label(ViewComponent $field) {
        return $field->label() ? $field->label() : $this->attributes()[$field->name()] ?? $field->name();
    }

    /**
     * @param Model $item
     * @param Field $field
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|string
     */
    public function value(Model $item, Field $field) {
        return $field instanceof SlideField || isset($item->{$field->name()}) ? $field->indexView($item) : '';
    }

    /**
     * @param Model $item
     * @param Field $field
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|string
     */
    public function exportValue(Model $item, Field $field) {
        return $field instanceof SlideField || isset($item->{$field->name()}) ? $field->exportView($item) : '';
    }

    /**
     * @param ViewComponent $component
     * @param $type
     * @param Model $item
     * @param boolean $onlyField
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function component(ViewComponent $component, $type, Model $item, $onlyField = false) {
        if ($component instanceof RelationInterface && method_exists($component, "options")) {
            $component->options(collect($item->{$component->relation()}()->getRelated()->all())->pluck($component->relationViewField(), "id")->toArray());
        }

        return view("admin::components.{$type}.component", ["resource" => $this, "item" => $item, "component" => $component, "onlyField" => $onlyField]);
    }

    public function extensions($name, Model $item) {
        $views = "";

        if(app("AdminExtensions")) {
            foreach (app("AdminExtensions") as $extension) {
                if(method_exists($extension, $name)) {
                    $views .= $extension->{$name}($item);
                }
            }
        }

        return $views;
    }
}