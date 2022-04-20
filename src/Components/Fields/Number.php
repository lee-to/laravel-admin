<?php

namespace Leeto\Admin\Components\Fields;


class Number extends Field
{
    public $view = 'text';

    public $type = 'number';

    public $stars = false;

    public $min = 0;

    public $max = 1000;

    public function stars()
    {
        $this->stars = true;

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

    public function indexView($item)
    {
        if($this->stars) {
            return view('admin::components.listing.partials.stars', [
                'value' => $item->{$this->name()}
            ]);
        } else {
            return parent::indexView($item);
        }
    }

}