<?php

namespace Leeto\Admin\Components\Filters;


class SwitchFilter extends Filter
{
    public $view = 'switch';

    public $onValue = 1;

    public $offValue = 0;

    public function onValue($onValue)
    {
        $this->onValue = $onValue;

        return $this;
    }

    public function offValue($offValue)
    {
        $this->offValue = $offValue;

        return $this;
    }
}