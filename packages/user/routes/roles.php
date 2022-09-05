<?php

use Illuminate\Support\Facades\Route;
use User\Http\Controllers\RolesController;

Route::middleware('auth:sanctum')->prefix('roles')->group(function () {
    Route::match(['option', 'post'], '/all', [RolesController::class, 'all'])->name('roles.all');
    Route::match(['option', 'post'], '/create', [RolesController::class, 'create'])->name('roles.create');
    Route::match(['option', 'post'], '/update', [RolesController::class, 'update'])->name('roles.update');
    Route::match(['option', 'post'], '/remove', [RolesController::class, 'remove'])->name('roles.remove');
    Route::match(['option', 'post'], '/user-assign', [RolesController::class, 'userAssign'])->name('roles.user-assign');
    Route::match(['option', 'post'], '/user-detach', [RolesController::class, 'userDetach'])->name('roles.user-detach');
});
