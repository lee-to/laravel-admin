<?php

namespace Leeto\Admin\Components;


use Illuminate\Support\Str;

class Menu
{
    protected $menu;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function get() {
        $menuData = [];

        $this->menu = $this->config ?? include app_path("Admin/menu.php");

        if(is_array($this->menu)) {
            foreach ($this->menu as $data) {
                $menuData[] = ["url" => action([$data["class"], 'index']), "data" => $data, "current" => Str::contains(request()->route()->getActionName(), $data["class"])];
            }
        }

        return $menuData;
    }
}