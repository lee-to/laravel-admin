<?php

namespace Leeto\Admin\Controllers;

use Leeto\Admin\Resources\AdminRoleResource;
use Leeto\Admin\Traits\ControllerTrait;

class AdminRoleController extends Controller
{
    use ControllerTrait;

    public function __construct()
    {
        $this->resource = new AdminRoleResource();
    }
}
