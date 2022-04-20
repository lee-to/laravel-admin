<?php

namespace Leeto\Admin\Components\Fields;


use Leeto\Admin\Traits\Fields\SelectTrait;
use Illuminate\Database\Eloquent\Model;

class Select extends Field
{
    use SelectTrait;

    public $view = 'select';

    public function indexView(Model $item)
    {
        if(isset($this->values()[$item->{$this->name()}])) {
            return $this->values()[$item->{$this->name()}];
        }

        return parent::indexView($item);
    }
}