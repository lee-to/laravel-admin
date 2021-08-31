<?php

namespace Leeto\Admin\Components\Fields;


use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Traits\Fields\SelectTrait;

class BelongsToMany extends Field implements RelationInterface
{
    use SelectTrait;

    public $view = "multi-checkbox";

    public function indexView($item)
    {
        return collect($item->{$this->relation()})->map(function ($item) {
            return str_replace("\"", "'", view("admin::components.partials.badge",
                ["color" => "purple", "value" => $item->{$this->relationViewField()}]));
        })->implode("");
    }

    public function exportView($item) {
        return collect($item->{$this->relation()})->map(function ($item) {
            return $item->{$this->relationViewField()};
        })->implode(";");
    }
}