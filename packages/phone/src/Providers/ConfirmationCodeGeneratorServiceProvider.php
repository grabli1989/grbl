<?php

namespace Phone\Providers;

use Illuminate\Support\ServiceProvider;
use Phone\Code\ConfirmationCodeGenerator;
use User\Interfaces\ConfirmationCodeGeneratorInterface;

class ConfirmationCodeGeneratorServiceProvider extends ServiceProvider
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
        $this->app->bind(ConfirmationCodeGeneratorInterface::class, function () {
            return new ConfirmationCodeGenerator();
        });
    }
}
