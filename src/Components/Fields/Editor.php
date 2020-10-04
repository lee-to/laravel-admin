<?php

namespace Leeto\Admin\Components\Fields;


class Editor extends Field
{
    public $view = "editor";

    protected $assets = [
        "js" => ["vendor/leeto-admin/js/trix/trix.js"],
        "css" => ["vendor/leeto-admin/css/trix/trix.css"],
    ];
}