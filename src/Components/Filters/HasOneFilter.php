<?php

namespace Leeto\Admin\Components\Filters;


use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Traits\Fields\SelectTrait;

class HasOneFilter extends Filter implements RelationInterface
{
    use SelectTrait;

    public $view = 'select';
}