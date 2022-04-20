<?php

namespace Leeto\Admin\Components\Fields;

use Illuminate\Support\Facades\Storage;
use Leeto\Admin\Components\RelationInterface;
use Leeto\Admin\Traits\Fields\SelectTrait;

class Dropdown extends Field implements RelationInterface
{
    use SelectTrait;

    public $view = 'select-dropdown';

    public $imageField = '';

    public $link = '';

    public function imageField($imageField)
    {
        $this->imageField = $imageField;

        return $this;
    }

    public function link($link)
    {
        $this->link = $link;

        return $this;
    }

    public function indexView($item)
    {
        return view(
            'admin::components.partials.listing_item',
            [
                'link' => $this->link ? route("admin.{$this->link}.edit", $item->id) : '',
                'image' => $this->imageField ? Storage::url($item->{$this->relation()}->{$this->imageField}) : '',
                'value' => $item->{$this->relation()}->{$this->relationViewField()}
            ]
        );
    }

    public function exportView($item)
    {
        return $item->{$this->relation()}->{$this->relationViewField()};
    }
}