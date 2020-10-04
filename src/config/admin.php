<?php

return [
    'title' => env('ADMIN_TITLE', 'Laravel'),

    'auth' => [
        'controller' => Leeto\Admin\Controllers\IndexController::class,

        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'users',
            ],
        ],

        'remember' => true,

        'redirect_to' => 'admin/login',
    ],

    'route' => [
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],
    ],
];
