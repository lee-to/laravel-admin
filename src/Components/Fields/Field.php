<?php

namespace Leeto\Admin\Components\Fields;


use Illuminate\Database\Eloquent\Model;
use Leeto\Admin\Components\ViewComponent;
use Illuminate\Support\Str;
use Leeto\Admin\Traits\Fields\LinkTrait;
use Leeto\Admin\Traits\Fields\ShowWhenTrait;
use Leeto\Admin\Traits\Fields\SimpleFieldTrait;
use Leeto\Admin\Traits\Fields\XModelTrait;

/**
 * Class Field
 * @package Leeto\Admin\Components\Fields
 */
abstract class Field implements ViewComponent
{
    use SimpleFieldTrait, ShowWhenTrait, XModelTrait, LinkTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $originalName;

    /**
     * @var string
     */
    protected $parentRelation;

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
     * @var mixed
     */
    public $default;

    /**
     * @var string
     */
    public $hint;

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
        $name = Str::of($name);

        if($name->contains(".")) {
            $nameData = $name->explode(".");
            $this->parentRelation = $nameData->first();
            $name = $nameData->last();
        } else {
            $this->parentRelation = "";
        }

        $this->name = Str::lower($name);
        $this->originalName = $this->name;
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
    public function originalName() : string
    {
        return $this->originalName;
    }

    /**
     * @param string $name
     */
    public function setCustomName($name) : void
    {
        $this->name = $name;
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
    public function parentRelation() : string
    {
        return $this->parentRelation;
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
    public function default($default) {
        $this->default = $default;

        return $this;
    }

    /**
     * @return $this
     */
    public function hint($hint) {
        $this->hint = $hint;

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