<?php

use Illuminate\Support\Facades\Route;
use Photo\Http\Controllers\PhotoController;

Route::middleware(['auth:sanctum'])->prefix('/photos')->group(function () {
    Route::match(['option', 'post'], '/append-photo', [PhotoController::class, 'appendPhoto'])->name('photos.append-photo');
    Route::match(['option', 'post'], '/get', [PhotoController::class, 'get'])->name('photos.get')->where('id', '\d+');
});
