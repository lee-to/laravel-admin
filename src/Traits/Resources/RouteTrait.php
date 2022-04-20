<?php

namespace Leeto\Admin\Traits\Resources;

use Illuminate\Support\Str;

/**
 * Trait RouteTrait
 * @package Leeto\Admin\Traits\Resources
 */
trait RouteTrait
{

    /**
     * @param $action
     * @param null $id
     * @return string
     */
    public function route($action, $id = null)
    {
        $route = Str::beforeLast(request()->route()->getName(), '.');

        if($id) {
            $parameter = Str::singular(Str::afterLast($route, 'admin.'));

            return route($route . ".{$action}", [$parameter => $id]);
        } else {
            return route($route . ".{$action}");
        }
    }
}