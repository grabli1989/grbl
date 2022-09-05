<?php

namespace Markable\Providers;

use Illuminate\Support\ServiceProvider;
use Markable\Managers\ViewsManager;
use Realty\Interfaces\ViewsManagerInterface;

class ViewsManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ViewsManagerInterface::class, function () {
            return new ViewsManager();
        });
    }
}
