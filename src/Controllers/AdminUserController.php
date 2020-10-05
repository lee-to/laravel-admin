<?php

namespace Leeto\Admin\Controllers;

use Leeto\Admin\Resources\AdminUserResource;
use Leeto\Admin\Traits\ControllerTrait;

class AdminUserController extends Controller
{
    use ControllerTrait;

    public function __construct()
    {
        $this->resource = new AdminUserResource();
    }
}
