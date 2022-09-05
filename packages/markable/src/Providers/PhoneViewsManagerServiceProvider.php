<?php

namespace Markable\Providers;

use Illuminate\Support\ServiceProvider;
use Markable\Managers\PhoneViewsManager;
use Realty\Interfaces\PhoneViewsServiceInterface;

class PhoneViewsManagerServiceProvider extends ServiceProvider
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
        $this->app->bind(PhoneViewsServiceInterface::class, function () {
            return new PhoneViewsManager(request());
        });
    }
}
