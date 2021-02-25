<?php


namespace Leeto\Admin\Components\Decorations;

use Leeto\Admin\Components\Fields\Field;

class Tab extends Decoration
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function formFields(): array
    {
        return collect($this->fields)->filter(function ($item) {
            return $item instanceof Field && $item->form;
        })->toArray();
    }

    /**
     * @param array $fields
     * @return Tab
     */
    public function setFields(array $fields): Tab
    {
        $this->fields = $fields;

        return $this;
    }
}