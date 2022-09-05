<?php

use Realty\Http\Controllers\FavoritesController;
use Realty\Http\Controllers\PhoneViewsController;
use Realty\Interfaces\RoutesInterface;

Route::prefix(RoutesInterface::REACTIONS_PREFIX['FAVORITES'])->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::match(['option', 'post'], '/add', [FavoritesController::class, 'add'])
            ->name(RoutesInterface::REACTIONS_PREFIX['FAVORITES'].'.add');

        Route::match(['option', 'post'], '/remove', [FavoritesController::class, 'remove'])
            ->name(RoutesInterface::REACTIONS_PREFIX['FAVORITES'].'.remove');

        Route::match(['option', 'post'], '/toggle', [FavoritesController::class, 'toggle'])
            ->name(RoutesInterface::REACTIONS_PREFIX['FAVORITES'].'.toggle');

        Route::match(['option', 'post'], '/has', [FavoritesController::class, 'has'])
            ->name(RoutesInterface::REACTIONS_PREFIX['FAVORITES'].'.has');

        Route::match(['option', 'post'], '/count', [FavoritesController::class, 'count'])
            ->name(RoutesInterface::REACTIONS_PREFIX['FAVORITES'].'.count');
    });
});

Route::prefix(RoutesInterface::REACTIONS_PREFIX['PHONE_VIEWS'])->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::match(['option', 'post'], '/add', [PhoneViewsController::class, 'add'])
            ->name(RoutesInterface::REACTIONS_PREFIX['PHONE_VIEWS'].'.add');

        Route::match(['option', 'post'], '/remove', [PhoneViewsController::class, 'remove'])
            ->name(RoutesInterface::REACTIONS_PREFIX['PHONE_VIEWS'].'.remove');

        Route::match(['option', 'post'], '/toggle', [PhoneViewsController::class, 'toggle'])
            ->name(RoutesInterface::REACTIONS_PREFIX['PHONE_VIEWS'].'.toggle');

        Route::match(['option', 'post'], '/has', [PhoneViewsController::class, 'has'])
            ->name(RoutesInterface::REACTIONS_PREFIX['PHONE_VIEWS'].'.has');

        Route::match(['option', 'post'], '/count', [PhoneViewsController::class, 'count'])
            ->name(RoutesInterface::REACTIONS_PREFIX['PHONE_VIEWS'].'.count');
    });
});
