<?php

namespace Search\Providers;

use Illuminate\Support\ServiceProvider;
use Realty\Interfaces\SearchServiceInterface;
use Search\Services\SearchService;

class SearchServiceProvider extends ServiceProvider
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
        $this->app->bind(SearchServiceInterface::class, function () {
            return new SearchService();
        });
    }
}
