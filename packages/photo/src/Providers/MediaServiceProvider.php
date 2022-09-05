<?php

namespace Photo\Providers;

use Illuminate\Support\ServiceProvider;
use Photo\Media\MediaService;
use Realty\Interfaces\MediaServiceInterface;

class MediaServiceProvider extends ServiceProvider
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
        $this->app->bind(MediaServiceInterface::class, function () {
            return new MediaService();
        });
    }
}
