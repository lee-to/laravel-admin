<?php


namespace Leeto\Admin\Components\Decorations;

use Leeto\Admin\Components\ViewComponent;

class Decoration implements ViewComponent
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    public $view;

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Field constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $name
     */
    protected function setName(string $name): void
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}