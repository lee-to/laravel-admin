<?php

namespace Leeto\Admin\Components;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Leeto\Admin\Components\Fields\BelongsToMany;
use Leeto\Admin\Components\Fields\HasMany;
use Leeto\Admin\Components\Fields\HasManyExtend;
use Leeto\Admin\Components\Fields\SlideField;
use Leeto\Admin\Components\Fields\SubItemInterface;
use Leeto\Admin\Resources\ResourceInterface;

/**
 * Class FieldComponent
 * @package Leeto\Admin\Components
 */
class FieldComponent extends Component
{
    /**
     * @var
     */
    public $value;

    /**
     * @var
     */
    public $emptyValue;

    /**
     * @var
     */
    public $label;

    /**
     * @var
     */
    public $attr;

    /**
     * @var string
     */
    public $view;

    /**
     * @var bool|mixed
     */
    public $relation = false;

    /**
     * @var bool
     */
    public $relationMethod = false;

    /**
     * @var ResourceInterface
     */
    public $resource;

    /**
     * @var ViewComponent
     */
    public $component;

    /**
     * @var Model|null
     */
    public $item;

    /**
     * FieldComponent constructor.
     * @param ResourceInterface $resource
     * @param ViewComponent $component
     * @param Model|null $item
     */
    public function __construct(ResourceInterface $resource, ViewComponent $component, Model $item = null)
    {
        $this->resource = $resource;
        $this->component = $component;
        $this->item = $item;
        $this->value = $item instanceof Model && $component->type() != "password" ? $item->{$component->originalName(
        )} : old($component->originalName());
        $this->emptyValue = $this->value;

        if (is_null($this->value) || $this->value == "") {
            $this->value = $component->default;
        }

        $this->label = $resource->label($component);
        $this->view = $component->getView();

        if ($item instanceof Model && $component instanceof RelationInterface) {
            $this->relation = $item->{$component->relation()};
            $this->relationMethod = $item->{$component->relation()}();
        }

        if ($item instanceof Model && $component instanceof SlideField) {
            $component->maxValue($item->{$component->maxName});
            $component->minValue($item->{$component->minName});
        }

        $this->attr = $component->attributes();

        if($component instanceof HasMany || $component instanceof BelongsToMany) {
            if(!Str::of($this->attr["name"])->endsWith("[]")) {
                $this->attr["name"] = Str::of($this->attr["name"])->append("[]");
            }
        }

        if ($component->xModel) {
            $xModelInputName = "item.input_name_{$component->originalName()}";

            $this->attr["_attr"] = "x-model=\"{$component->xModelField()}\" :name='{$xModelInputName}'";
        }

        if ($resource->isWhenConditionField($component->name())) {
            $this->attr["_attr"] = "x-model=\"{$component->name()}\"";
        }

        if ($component instanceof RelationInterface) {
            if ($this->value instanceof Collection) {
                if ($this->value->isEmpty()) {
                    $this->value->push($this->relationMethod->getRelated());
                }

                $this->emptyValue = $this->value instanceof Collection ? $this->relationMethod->getRelated(
                ) : $this->value;
            }
        }
    }

    /**
     * @return \Closure|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Support\Htmlable|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view("admin::components.fields.{$this->view}");
    }
}