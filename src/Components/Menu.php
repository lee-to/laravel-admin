<?php

namespace Leeto\Admin\Components;


use Illuminate\Support\Str;

class Menu
{
    protected static $menu;

    public static function get() {
        $menuData = [];

        static::$menu = include app_path("Admin/menu.php");

        if(is_array(static::$menu)) {
            foreach (static::$menu as $data) {
                $menuData[] = ["url" => action([$data["class"], 'index']), "data" => $data, "current" => Str::contains(request()->route()->getActionName(), $data["class"])];
            }
        }

        return $menuData;
    }
}