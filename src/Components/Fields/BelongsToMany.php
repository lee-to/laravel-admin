<?php

namespace Leeto\Admin\Components\Fields;


use Leeto\Admin\Components\PivotInterface;
use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Traits\Fields\SelectTrait;

class BelongsToMany extends Field implements RelationInterface, PivotInterface
{
    use SelectTrait;

    public $view = 'multi-checkbox';

    public $fields = [];

    public function getFields()
    {
        return $this->fields;
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;

        foreach ($fields as $field) {
            $field->setCustomName($this->originalName() . '_' . $field->originalName() . '[]');
        }

        return $this;
    }

    public function indexView($item)
    {
        return collect($item->{$this->relation()})->map(function ($item) {
            return str_replace("\"", "'", view('admin::components.partials.badge',
                ['color' => 'purple', 'value' => $item->{$this->relationViewField()}]));
        })->implode('');
    }

    public function exportView($item) {
        return collect($item->{$this->relation()})->map(function ($item) {
            return $item->{$this->relationViewField()};
        })->implode(';');
    }
}