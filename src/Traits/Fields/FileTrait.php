<?php

namespace Leeto\Admin\Traits\Fields;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileTrait
{
    public $multiple = false;

    protected $added = [];

    protected function setAdded($added)
    {
        $this->added = $added;
    }

    protected function getAdded()
    {
        return $this->added;
    }

    public function multiple()
    {
        $this->multiple = true;

        return $this;
    }

    public function src($path)
    {
        return $path ? Storage::url($path) : '';
    }

    public function sync($values, $detach = false)
    {
        if($this->multiple) {
            if(request()->has("sync_{$this->name()}")) {
                $hidden = collect(request("hidden_{$this->name()}") ?? []);
                if($detach) {
                    $remove = collect($values)->diff($hidden);
                    if($remove->count()) {
                        $values = collect($values)->reject(function ($value) use($remove) {
                            return in_array($value, $remove->toArray());
                        })->merge($this->getAdded())->toArray();
                    }
                } else {
                    $values = $hidden->merge($values);
                }
            }
        }

        return $values;
    }

    public function save()
    {
        $result = [];

        if(!request()->hasFile($this->name())) {
            return false;
        }

        $files = $this->multiple ? request()->file($this->name()) : [request()->file($this->name())];

        foreach ($files as $file) {
            $mime = $file->getMimeType();

            if(empty($this->allowedFileExtension) || array_search(Str::after($mime, '/'), $this->allowedFileExtension)) {
                $result[] = $file->store($this->dir, 'public');
            }
        }

        $this->setAdded($result);

        return $this->multiple ? $result : collect($result)->first();
    }
}