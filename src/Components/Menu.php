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

    public function get()
    {
        $menuData = [];

        $this->menu = $this->config ?? include app_path('Admin/menu.php');

        if(is_array($this->menu)) {
            foreach ($this->menu as $data) {
                $dropdown = isset($data['dropdown']) ? collect($data['dropdown']) : collect();

                $dropdown = $dropdown->map(function ($item) {
                    return [
                        'url' => action([$item['class'], $item['action'] ?? 'index']),
                        'data' => $item,
                        'current' => $this->current($item['class'], $item['action'] ?? null)
                    ];
                });

                $menuData[] = [
                    "url" => action([$data["class"], $data["action"] ?? 'index']),
                    "data" => $data,
                    "current" => $this->current($data["class"], $data["action"] ?? null),
                    "icon" => $data["icon"] ?? 'app',
                    "dropdown" => $dropdown
                ];
            }
        }

        return $menuData;
    }

    protected function current($class, $action = null) {
        if($action) {
            return request()->route()->getActionName() == "{$class}@{$action}";
        }

        return Str::contains($class, Str::before(request()->route()->getActionName(), "@"));
    }
}