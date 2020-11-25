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
        return collect($this->fields())->filter(function ($value) {
            return $value->form;
        });
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

    public function getAssets($type) {
        $assets = [];

        foreach ($this->fields() as $field) {
            if($field->getAssets()) {
                $assets = array_merge($field->getAssets(), $assets);
            }
        }

        return $assets[$type] ?? [];
    }

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
        return $field instanceof SlideField || $item->{$field->name()} ? $field->indexView($item) : '';
    }

    /**
     * @param Model $item
     * @param Field $field
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|string
     */
    public function exportValue(Model $item, Field $field) {
        return $field instanceof SlideField || $item->{$field->name()} ? $field->exportView($item) : '';
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
}