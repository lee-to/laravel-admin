<?php

namespace Leeto\Admin\Components\Fields;


use Leeto\Admin\Traits\Fields\FileTrait;
use Illuminate\Support\Facades\Storage;

class Image extends Field implements FileInterface
{
    use FileTrait;

    public $view = "image";

    public $type = "file";

    public $dir = "images";

    public $allowedFileExtension = ['jpg', 'png', 'gif', 'jpeg'];

    public function src($path, $size = "50x50") {
        return $path ? Storage::url($path) : "https://via.placeholder.com/{$size}.png/4FA7F8/fff?text=PHOTO";
    }

    public function indexView($item) {
        if($this->multiple) {
            $this->removeable(false);

            return collect($item->{$this->name()})->map(function ($value) {
                return str_replace("\"", "'", view("admin::components.partials.thumbnail", ["type" => "carousel", "value" => $value, "field" => $this]));
            })->implode("");
        }

        return view("admin::components.partials.thumbnail", ["type" => "avatar", "value" => $item->{$this->name()}, "field" => $this]);
    }

    public function exportView($item) {
        if($this->multiple) {
            return collect($item->{$this->name()})->map(function ($value) {
                return $value;
            })->implode(";");
        }

        return parent::exportView($item);
    }
}