<?php

namespace Leeto\Admin\Providers;

use Illuminate\Support\Facades\Blade;
use Leeto\Admin\Commands\CreateUserCommand;
use Leeto\Admin\Commands\GenerateCommand;
use Leeto\Admin\Commands\InstallCommand;
use Leeto\Admin\Components\FieldComponent;
use Leeto\Admin\Components\Menu;
use Leeto\Admin\Components\MenuComponent;
use Leeto\Admin\Components\ModalComponent;
use Leeto\Admin\Middleware\Authenticate;
use Leeto\Admin\Middleware\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    protected $commands = [
        InstallCommand::class,
        GenerateCommand::class,
        CreateUserCommand::class,
    ];

    protected $routeMiddleware = [
        'admin.auth' => Authenticate::class,
        'admin.session' => Session::class,
    ];

    protected $middlewareGroups = [
        'admin' => [
            'admin.auth',
        ],
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadAdminAuthConfig();

        $this->registerRouteMiddleware();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../lang' => resource_path('lang')], 'leeto-admin-lang');
        $this->publishes([__DIR__.'/../migrations' => database_path('migrations')], 'laravel-admin-migrations');
        $this->publishes([__DIR__.'/../assets' => public_path('vendor/leeto-admin')], 'leeto-admin-assets');

        $this->publishes([
            __DIR__ . '/../config/admin.php' => config_path('admin.php'),
        ]);

        if (file_exists($routes = app_path('Admin/routes.php'))) {
            $this->loadRoutesFrom($routes);
        }

        $this->loadViewsFrom(__DIR__. '/../views', 'admin');

        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/admin'),
        ]);

        $this->commands($this->commands);

        Blade::withoutDoubleEncoding();
        Blade::component('menu', MenuComponent::class);
        Blade::component('modal', ModalComponent::class);
        Blade::component('field', FieldComponent::class);

        $this->app->singleton('Menu', function ($app) {
            return new \Leeto\Admin\Components\Menu(include_once app_path("Admin/menu.php"));
        });
    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(Arr::dot(config('admin.auth', []), 'auth.'));
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
