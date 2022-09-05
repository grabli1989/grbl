<?php

namespace Settings\Providers;

use Illuminate\Support\ServiceProvider;
use Realty\Interfaces\SettingsServiceInterface;
use Settings\Services\SettingsService;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
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
        $this->app->bind(SettingsServiceInterface::class, function () {
            return new SettingsService();
        });
    }
}
