<?php

namespace Leeto\Admin\Components\Fields;

use Leeto\Admin\Traits\Fields\FileTrait;

class File extends Field implements FileInterface
{
    use FileTrait;

    public $view = 'file';

    public $type = 'file';

    public $dir = 'files';

    public $allowedFileExtension = [];

    public function indexView($item)
    {
        if($this->multiple) {
            $this->removeable(false);

            return collect($item->{$this->name()})->map(function ($value, $key) {
                return str_replace("\"", "'", view('admin::components.partials.file', [
                        'value' => $value,
                        'index' => $key,
                        'attr' => $this->attributes()
                ]));
            })->implode('');
        }

        return view(
            'admin::components.partials.file',
            [
                'type' => 'single',
                'value' => $item->{$this->name()},
                'field' => $this
            ]
        );
    }

    public function exportView($item)
    {
        if($this->multiple) {
            return collect($item->{$this->name()})->map(function ($value) {
                return $value;
            })->implode(';');
        }

        return parent::exportView($item);
    }
}