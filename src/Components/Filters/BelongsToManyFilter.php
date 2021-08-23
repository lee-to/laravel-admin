<?php

namespace Leeto\Admin\Components\Filters;


use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Traits\Fields\SelectTrait;

class BelongsToManyFilter extends Filter implements RelationInterface
{
    use SelectTrait;

    public $view = "multi-checkbox";
}