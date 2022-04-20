<?php

namespace Leeto\Admin\Components\Filters;


use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Traits\Fields\SelectTrait;

class HasManyFilter extends Filter implements RelationInterface
{
    use SelectTrait;

    public $view = 'multi-select';
}