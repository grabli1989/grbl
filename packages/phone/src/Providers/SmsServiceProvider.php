<?php

namespace Phone\Providers;

use Illuminate\Support\ServiceProvider;
use Phone\SmsProvider\SmsProvider;
use User\Interfaces\SmsServiceInterface;

class SmsServiceProvider extends ServiceProvider
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
        $this->app->bind(SmsServiceInterface::class, function () {
            return new SmsProvider();
        });
    }
}
