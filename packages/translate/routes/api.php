<?php

use Illuminate\Support\Facades\Route;
use Translate\Http\Controllers\TranslateController;

Route::middleware(['auth:sanctum'])->prefix('/translate')->group(function () {
    Route::match(['option', 'post'], '/translate', [TranslateController::class, 'translate'])->name('translate.translate');
});
