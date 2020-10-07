<?php

namespace Leeto\Admin\Components;

use Illuminate\View\Component;

class MenuComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        $data = app("Menu")->get();

        return view('admin::components.menu', [
            "data" => $data,
        ]);
    }
}