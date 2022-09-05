<?php

use Illuminate\Support\Facades\Route;
use Settings\Http\Controllers\SettingsController;

Route::prefix('/settings')->middleware(['auth:sanctum'])->group(function () {
    Route::match(['option', 'post'], '/get', [SettingsController::class, 'get'])->name('settings.get');
    Route::match(['option', 'post'], '/put', [SettingsController::class, 'put'])->name('settings.put');
    Route::match(['option', 'post'], '/drop', [SettingsController::class, 'drop'])->name('settings.drop');
    Route::match(['option', 'post'], '/user-assign-setting', [SettingsController::class, 'userAssignSetting'])->name('settings.user-assign-setting');
    Route::match(['option', 'post'], '/user-revoke-setting', [SettingsController::class, 'userRevokeSetting'])->name('settings.user-revoke-setting');
});
