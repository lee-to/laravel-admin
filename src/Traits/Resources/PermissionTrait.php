<?php

namespace Leeto\Admin\Traits\Resources;

/**
 * Trait PermissionTrait
 * @package Leeto\Admin\Traits\Resources
 */
trait PermissionTrait
{

    public function can(): array
    {
        return [
            'list' => [],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ];
    }
}