<?php

namespace Leeto\Admin\Extensions;

use Illuminate\Database\Eloquent\Model;

class Extension
{
    public $tabs = [];

    public function formFields() {
        return [];
    }

    public function editTabs(Model $item) {
        return view("admin::components.partials.tabs", ["tabs" => $this->tabs]);
    }
}