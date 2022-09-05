<?php

use Illuminate\Support\Facades\Route;
use Realty\Http\Controllers\AdsController;
use Realty\Interfaces\RoutesInterface;

Route::prefix(RoutesInterface::ADS_PREFIX)->group(function () {
    Route::match(['option', 'post'], '/', [AdsController::class, 'ad'])
        ->withoutMiddleware('userIsConfirmed')->name('ads.ad');
    Route::match(['option', 'post'], '/approved-ads', [AdsController::class, 'approvedAds'])
        ->withoutMiddleware('userIsConfirmed')->name('ads.approved-ads');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::match(['option', 'post'], '/self-'.RoutesInterface::ADS_PREFIX.'s', [AdsController::class, 'selfAds'])->name('ads.self-ads');
        Route::match(['option', 'post'], '/create', [AdsController::class, 'create'])->name('ads.create');
        Route::match(['option', 'post'], '/update', [AdsController::class, 'update'])->name('ads.update');
        Route::match(['option', 'post'], '/remove', [AdsController::class, 'remove'])->name('ads.remove');
        Route::match(['option', 'post'], '/disable', [AdsController::class, 'disable'])->name('ads.disable');

        Route::match(['option', 'post'], '/approve', [AdsController::class, 'approve'])->name('ads.approve');
        Route::match(['option', 'post'], '/reject', [AdsController::class, 'reject'])->name('ads.reject');
    });
});
