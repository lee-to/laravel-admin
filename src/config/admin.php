<?php

return [
    'title' => env('ADMIN_TITLE', 'Laravel'),

    'auth' => [
        'controller' => Leeto\Admin\Controllers\IndexController::class,

        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'remember' => true,

        'redirect_to' => 'admin/login',

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => \Leeto\Admin\Models\AdminUser::class,
            ],
        ],
    ],

    'route' => [
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],
    ],
];
