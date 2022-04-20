<?php

namespace Leeto\Admin\Components\Filters;


use Leeto\Admin\Traits\Fields\SelectTrait;

class SelectFilter extends Filter
{
    use SelectTrait;

    public $view = 'select';
}