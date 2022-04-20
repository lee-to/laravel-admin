<?php


namespace Leeto\Admin\Traits\Fields;


use Illuminate\Support\Str;
use Leeto\Admin\Components\Fields\Field;

trait LinkTrait
{
    protected $linkValue;

    protected $linkName;

    public function hasLink()
    {
        return $this->getLinkValue() != '';
    }

    public function getLinkName()
    {
        return $this->linkName;
    }

    public function getLinkValue()
    {
        return $this->linkValue;
    }

    public function addLink($name, $link)
    {
        $this->linkValue = $link;
        $this->linkName = $name;

        return $this;
    }
}