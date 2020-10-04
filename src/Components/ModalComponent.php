<?php

namespace Leeto\Admin\Components;

use Illuminate\View\Component;

class ModalComponent extends Component
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
        return view('admin::components.modal', [

        ]);
    }
}