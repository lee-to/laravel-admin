<?php


namespace Leeto\Admin\Traits\Fields;


use Leeto\Admin\Components\Filters\Filter;

trait SimpleFieldTrait
{
    /**
     * @var string
     */
    protected $label = null;

    /**
     * @var mixed
     */
    public $default;

    /**
     * @return null|string
     */
    public function label() {
        return $this->label;
    }

    /**
     * @return $this
     */
    public function defaultLabel($label) {
        $this->label = $label;

        return $this;
    }

    /**
     * @return $this
     */
    public function default($default) {
        $this->default = $default;

        return $this;
    }
}