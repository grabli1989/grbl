<?php

namespace Modules\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Routes\RoutesCollection;

class RouteServiceProvider extends ServiceProvider
{
    public const API_PREFIX = 'v1';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $config = $this->app->make('modules');

        $apiFiles = [];
        $webFiles = [];

        foreach ($config->all() as $moduleConfig) {
            $routes = $moduleConfig['routes'] ?? [];
            if (! empty($routes)) {
                $apiFiles = array_merge($apiFiles, $routes['api'] ?? []);
                $webFiles = array_merge($webFiles, $routes['web'] ?? []);
            }
        }
        $this->loadModuleRoutes(new RoutesCollection($apiFiles, $webFiles));
    }

    /**
     * @param  array  $api
     * @return void
     */
    protected function loadApiRoutes(array $api): void
    {
        foreach ($api as $route) {
            Route::middleware('api')
                ->prefix($this->getApiPrefix())
                ->group($route);
        }
    }

    /**
     * @param  array  $web
     * @return void
     */
    protected function loadWebRoutes(array $web): void
    {
        foreach ($web as $route) {
            Route::middleware('web')
                ->group($route);
        }
    }

    /**
     * @return string
     */
    protected function getApiPrefix(): string
    {
        return self::API_PREFIX;
    }

    /**
     * @param  RoutesCollection  $routes
     * @return void
     */
    protected function loadModuleRoutes(RoutesCollection $routes): void
    {
        $this->routes(function () use ($routes) {
            $this->loadApiRoutes($routes->getApiRoutes());
            $this->loadWebRoutes($routes->getWebRoutes());
        });
    }
}
