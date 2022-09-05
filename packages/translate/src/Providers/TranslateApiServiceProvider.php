<?php

namespace Translate\Providers;

use Illuminate\Support\ServiceProvider;
use Realty\Interfaces\TranslateApiInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Translate\TranslateApi\TranslateApi;

class TranslateApiServiceProvider extends ServiceProvider
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
        $this->app->bind(TranslateApiInterface::class, function () {
            return new TranslateApi(new GoogleTranslate());
        });
    }
}
