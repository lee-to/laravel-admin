<?php

namespace Leeto\Admin\Components\Fields;


class Date extends Field
{
    public $view = "text";

    public $type = "date";

    public $format = "Y-m-d H:i:s";

    public function format($format) {
        $this->format = $format;

        return $this;
    }

    public function indexView($item)
    {
        return date($this->format, strtotime($item->{$this->name()}));
    }
}