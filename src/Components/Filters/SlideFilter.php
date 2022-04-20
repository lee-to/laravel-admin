<?php

namespace Leeto\Admin\Components\Filters;


class SlideFilter extends Filter
{
    public $view = 'slide';

    public $step = 1;
    public $min = 1;
    public $max = 10;

    public function step($value)
    {
        $this->step = $value;

        return $this;
    }

    public function min($value)
    {
        $this->min = $value;

        return $this;
    }

    public function max($value)
    {
        $this->max = $value;

        return $this;
    }
}