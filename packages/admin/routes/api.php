<?php

use Admin\Http\Controllers\AdminController;

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::match(['option', 'post'], '/users-all', [AdminController::class, 'usersAll'])->name('admin.users-all');
    Route::match(['option', 'post'], '/user-get', [AdminController::class, 'userGet'])->name('admin.user-get');
    Route::match(['option', 'post'], '/update-user', [AdminController::class, 'updateUser'])->name('admin.update-user');


    Route::match(['option', 'post'], '/ads-all', [AdminController::class, 'adsAll'])->name('admin.ads-all');
});
