<?php

namespace Leeto\Admin\Traits\Fields;


trait SelectTrait
{

    protected $multiple = false;

    protected $options = [];

    public function multiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function options(array $data)
    {
        $this->options = $data;

        return $this;
    }

    public function values()
    {
        return $this->options;
    }
}