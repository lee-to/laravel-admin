<?php

namespace Leeto\Admin\Components;


interface ViewComponent
{
    public function getView() : string;

    public function name() : string;
}