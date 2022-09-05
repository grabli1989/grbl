<?php

namespace Markable\Providers;

use Illuminate\Support\ServiceProvider;
use Markable\Managers\FavoritesManager;
use Realty\Interfaces\FavoriteServiceInterface;

class FavoriteManagerServiceProvider extends ServiceProvider
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
        $this->app->bind(FavoriteServiceInterface::class, function () {
            return new FavoritesManager(request());
        });
    }
}
