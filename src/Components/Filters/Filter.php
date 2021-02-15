<?php

namespace Leeto\Admin\Components\Filters;


use Leeto\Admin\Components\ViewComponent;
use Illuminate\Support\Str;

/**
 * Class Filter
 * @package Leeto\Admin\Components\Filters
 */
abstract class Filter implements ViewComponent
{
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
     * @var mixed
     */
    public $default;

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
     * @return $this
     */
    public function default($default) {
        $this->default = $default;

        return $this;
    }

    /**
     * @return string
     */
    public function getView() : string
    {
        return $this->view;
    }
}