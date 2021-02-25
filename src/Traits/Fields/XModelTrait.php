<?php


namespace Leeto\Admin\Traits\Fields;


use Illuminate\Support\Str;
use Leeto\Admin\Components\Fields\Field;

trait XModelTrait
{
    /**
     * @var bool
     */
    public $xModel = false;

    public $xModelRelation = null;

    /**
     * @return $this
     */
    public function xModel($xModelRelation = null) {
        $this->xModel = true;
        $this->xModelRelation = $xModelRelation;

        return $this;
    }

    /**
     * @return string
     */
    public function xModelField($variable = "item") {
        $field = Str::of($variable);

        if($field->isNotEmpty()) {
            $field = $field->append(".");
        }

        $field = $field->append($this->originalName());

        return $field->__toString();
    }
}