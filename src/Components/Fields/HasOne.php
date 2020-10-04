<?php

namespace Leeto\Admin\Components\Fields;


use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Traits\Fields\SelectTrait;

class HasOne extends Field implements RelationInterface
{
    use SelectTrait;

    public $view = "select";

    public function indexView($item)
    {
        return view("admin::components.partials.badge", ["color" => "green", "value" => $item->{$this->relation()}->{$this->relationViewField()}]);
    }

    public function exportView($item) {
        return $item->{$this->relation()}->{$this->relationViewField()};
    }
}