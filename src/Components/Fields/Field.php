<?php

namespace Leeto\Admin\Components\Fields;


use Illuminate\Database\Eloquent\Model;
use Leeto\Admin\Components\ViewComponent;
use Illuminate\Support\Str;

/**
 * Class Field
 * @package Leeto\Admin\Components\Fields
 */
abstract class Field implements ViewComponent
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
    public $type;

    /**
     * @var
     */
    public $view;

    /**
     * @var bool
     */
    public $sortable = false;

    /**
     * @var bool
     */
    public $required = false;

    /**
     * @var bool
     */
    public $removeable = false;

    /**
     * @var bool
     */
    public $disabled = false;

    /**
     * @var bool
     */
    public $index = true;

    /**
     * @var bool
     */
    public $export = false;

    /**
     * @var bool
     */
    public $form = true;


    protected $assets = [];

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Field constructor.
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

    public function attributes() {
        return get_object_vars($this);
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
     * @return string
     */
    public function type() {
        return $this->type;
    }

    /**
     * @return $this
     */
    public function required() {
        $this->required = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function removeable($removeable) {
        $this->removeable = $removeable;

        return $this;
    }

    /**
     * @return $this
     */
    public function disabled() {
        $this->disabled = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function export() {
        $this->export = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function sortable() {
        $this->sortable = true;

        return $this;
    }

    /**
     * @param bool $index
     * @return $this
     */
    public function index($index = true) {
        $this->index = $index;

        return $this;
    }

    /**
     * @param bool $form
     * @return $this
     */
    public function form($form = true) {
        $this->form = $form;

        return $this;
    }

    /**
     * @return array|\Illuminate\Http\Request|string
     */
    public function save() {
        return request($this->name()) ?? false;
    }

    /**
     * @return array
     */
    public function getAssets(): array
    {
        return $this->assets;
    }

    public function indexView(Model $item) {
        return $item->{$this->name()};
    }

    public function exportView(Model $item) {
        return strip_tags($item->{$this->name()});
    }
}