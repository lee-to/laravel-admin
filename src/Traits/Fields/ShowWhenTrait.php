<?php


namespace Leeto\Admin\Traits\Fields;


trait ShowWhenTrait
{
    public $showWhenState = false;

    public $showWhenField;

    public $showWhenValue;

    public function showWhen($field_name, $item_value) {
        $this->showWhenState = true;
        $this->showWhenField = $field_name;
        $this->showWhenValue = $item_value;

        return $this;
    }
}