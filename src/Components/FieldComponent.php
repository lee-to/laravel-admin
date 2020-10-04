<?php

namespace Leeto\Admin\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Leeto\Admin\Components\Fields\SlideField;
use Leeto\Admin\Resources\ResourceInterface;

class FieldComponent extends Component
{
    public $value;

    public $label;

    public $attr;

    public $view;

    public $relation = false;

    public $relationMethod = false;

    public function __construct(ResourceInterface $resource, ViewComponent $component, $item = null)
    {
        $this->value = $item && $component->type() != "password" ? $item->{$component->name()} : old($component->name());
        $this->label = $resource->label($component);
        $this->view = $component->getView();

        if($component instanceof RelationInterface) {
            $this->relation = $item->{$component->relation()};
            $this->relationMethod = $item->{$component->relation()}();
        }

        if($component instanceof SlideField) {
            $component->maxValue($item->{$component->maxName});
            $component->minValue($item->{$component->minName});
        }

        $this->attr = $component->attributes();
    }

    public function render()
    {
        return view("admin::components.fields.{$this->view}");
    }
}