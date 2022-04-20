<?php

namespace Leeto\Admin\Components\Fields;


use Illuminate\Database\Eloquent\Model;

class SlideField extends Field
{
    public $view = 'slide';

    public $minValue;

    public $maxValue;

    public $min = 1;

    public $max = 10;

    public $step = 1;

    public $minName;

    public $maxName;

    public function minName($minName)
    {
        $this->minName = $minName;

        return $this;
    }

    public function maxName($maxName)
    {
        $this->maxName = $maxName;

        return $this;
    }

    public function minValue($minValue)
    {
        $this->minValue = $minValue;

        return $this;
    }

    public function maxValue($maxValue)
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    public function min($min)
    {
        $this->min = $min;

        return $this;
    }

    public function max($max)
    {
        $this->max = $max;

        return $this;
    }

    public function step($step)
    {
        $this->step = $step;

        return $this;
    }

    public function indexView(Model $item)
    {
        return "{$item->{$this->minName}} - {$item->{$this->maxName}}";
    }

    public function exportView(Model $item)
    {
        return "{$item->{$this->minName}} - {$item->{$this->maxName}}";
    }
}