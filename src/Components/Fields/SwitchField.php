<?php

namespace Leeto\Admin\Components\Fields;


class SwitchField extends Field
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

    public function indexView($item)
    {
        $this->disabled();

        return view(
            'admin::components.fields.switch',
            [
                'value' => $item->{$this->name()},
                'attr' => $this->attributes()
            ]
        );
    }

}