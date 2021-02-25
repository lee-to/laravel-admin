<?php

namespace Leeto\Admin\Components\Filters;


use Leeto\Admin\Components\Fields\Field;
use Leeto\Admin\Components\ViewComponent;
use Illuminate\Support\Str;
use Leeto\Admin\Traits\Fields\SimpleFieldTrait;

/**
 * Class Filter
 * @package Leeto\Admin\Components\Filters
 */
abstract class Filter implements ViewComponent
{
    use SimpleFieldTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $relation;

    /**
     * @var string
     */
    protected $relationViewField;

    /**
     * @var
     */
    public $view;

    /**
     * @var bool
     */
    public $xModel = false;

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Filter constructor.
     * @param $name
     * @param null $relation
     * @param null $relationViewField
     */
    public function __construct($name, $relation = null, $relationViewField = null)
    {
        $this->name = Str::lower($name);
        $this->relation = Str::lower($relation);
        $this->relationViewField = Str::lower($relationViewField);
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function relation() : string
    {
        return $this->relation;
    }

    /**
     * @return string
     */
    public function relationViewField() : string
    {
        return $this->relationViewField;
    }

    /**
     * @return string
     */
    public function getView() : string
    {
        return $this->view;
    }

    /**
     * @return $this
     */
    public function xModel() {
        $this->xModel = true;

        return $this;
    }
}