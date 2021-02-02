<?php

namespace Leeto\Admin\Components;

use Illuminate\View\Component;

class HeaderButtonsComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        $path = app_path("Admin/header_buttons.php");
        $data = file_exists($path) ? include $path : [];

        return view('admin::components.header-buttons', [
            "data" => $data,
        ]);
    }
}