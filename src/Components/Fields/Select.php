<?php

namespace Leeto\Admin\Components\Fields;


use Leeto\Admin\Traits\Fields\SelectTrait;

class Select extends Field
{
    use SelectTrait;

    public $view = "select";
}