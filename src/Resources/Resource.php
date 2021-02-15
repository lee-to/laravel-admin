<?php

namespace Leeto\Admin\Resources;

use Leeto\Admin\Components\Fields\Date;
use Leeto\Admin\Components\Fields\Field;
use Leeto\Admin\Components\Fields\File;
use Leeto\Admin\Components\Fields\HasMany;
use Leeto\Admin\Components\Fields\HasOne;
use Leeto\Admin\Components\Fields\Image;
use Leeto\Admin\Components\Fields\Line;
use Leeto\Admin\Components\Fields\Number;
use Leeto\Admin\Components\Fields\SlideField;
use Leeto\Admin\Components\Fields\SwitchField;
use Leeto\Admin\Components\Filters\Filter;
use Leeto\Admin\Components\Filters\HasManyFilter;
use Leeto\Admin\Components\Filters\HasOneFilter;
use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Components\ViewComponent;
use Leeto\Admin\Traits\Resources\RouteTrait;
use Leeto\Admin\Traits\Resources\QueryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
            return $value->form;
        }));

        return $fields;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function indexFields() {
        return collect($this->fields())->filter(function ($value) {
            return $value->index;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportFields() {
        return collect($this->fields())->filter(function ($value) {
            return $value->export;
        });
    }

    /**
     * @param $type
     * @return array|mixed
     */
    public function getAssets($type) {
        $assets = [];

        foreach ($this->fields() as $field) {
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

        return collect($this->fields())->filter(function ($value) use($name) {
            /* @var \Leeto\Admin\Components\Fields\Field $value */
            return $value->name() == $name;
        })->first();
    }

    /**
     * @param ViewComponent $field
     * @return string
     */
    public function label(ViewComponent $field) {
        return $this->attributes()[$field->name()] ?? $field->name();
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
     * @return string
     */
    public function exportUrl() {
        $exportQuery = Str::of("?_export=1");

        if(request()->has("filters")) {
            foreach (request()->query("filters") as $filterField => $filterQuery) {
                if(is_array($filterQuery)) {
                    foreach ($filterQuery as $filterInnerField => $filterValue) {
                        if(is_numeric($filterInnerField)) {
                            foreach ($filterValue as $filterIdsValue) {
                                $exportQuery = $exportQuery->append("&filters[{$filterField}][]={$filterIdsValue}");
                            }
                        } else {
                            $exportQuery = $exportQuery->append("&filters[{$filterInnerField}]={$filterValue}");
                        }

                    }
                } else {
                    $exportQuery = $exportQuery->append("&filters[{$filterField}]={$filterQuery}");
                }

            }
        }

        return $this->route("index") . $exportQuery;
    }

    /**
     * @param Model $item
     * @param ViewComponent $component
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function component(Model $item, ViewComponent $component, $type) {
        if ($component instanceof RelationInterface && method_exists($component, "options")) {
            $component->options(collect($item->{$component->relation()}()->getRelated()->all())->pluck($component->relationViewField(), "id")->toArray());
        }

        return view("admin::components.{$type}.component", ["resource" => $this, "item" => $item, "component" => $component]);
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