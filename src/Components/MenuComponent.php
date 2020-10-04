<?php

namespace Leeto\Admin\Components;

use Illuminate\View\Component;

class MenuComponent extends Component
{
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        $data = Menu::get();

        return view('admin::components.menu', [
            "data" => $data,
        ]);
    }
}