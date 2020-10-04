<?php

namespace Leeto\Admin\Traits\Fields;


trait SelectTrait {

    protected $options = [];

    public function options(array $data) {
        $this->options = $data;

        return $this;
    }

    public function values() {
        return $this->options;
    }
}