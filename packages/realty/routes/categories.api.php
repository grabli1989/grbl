<?php

use Illuminate\Support\Facades\Route;
use Realty\Http\Controllers\CategoriesController;

Route::prefix('/categories')->group(function () {
    Route::match(['option', 'post'], '/', [CategoriesController::class, 'all'])
        ->withoutMiddleware('userIsConfirmed')->name('categories.all');

    Route::match(['option', 'post'], '/get', [CategoriesController::class, 'category'])
        ->withoutMiddleware('userIsConfirmed')->name('categories.get')
        ->where('id', '\d+');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::match(['option', 'post'], '/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::match(['option', 'post'], '/update', [CategoriesController::class, 'update'])->name('categories.update');
        Route::match(['option', 'post'], '/remove', [CategoriesController::class, 'remove'])->name('categories.remove');
    });
});
