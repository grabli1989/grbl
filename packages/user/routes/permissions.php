<?php

use Illuminate\Support\Facades\Route;
use User\Http\Controllers\PermissionsController;

Route::middleware('auth:sanctum')->prefix('permissions')->group(function () {
    Route::match(['option', 'post'], '/all', [PermissionsController::class, 'all'])->name('permissions.all');
    Route::match(['option', 'post'], '/create', [PermissionsController::class, 'create'])->name('permissions.create');
    Route::match(['option', 'post'], '/update', [PermissionsController::class, 'update'])->name('permissions.update');
    Route::match(['option', 'post'], '/remove', [PermissionsController::class, 'remove'])->name('permissions.remove');
    Route::match(['option', 'post'], '/assign-role', [PermissionsController::class, 'assignRole'])->name('permissions.assign-role');
    Route::match(['option', 'post'], '/user-give-permission-to', [PermissionsController::class, 'userGivePermissionTo'])->name('permissions.user-give-permission-to');
    Route::match(['option', 'post'], '/remove-role', [PermissionsController::class, 'removeRole'])->name('permissions.remove-role');
    Route::match(['option', 'post'], '/user-revoke-permission-to', [PermissionsController::class, 'userRevokePermissionTo'])->name('permissions.user-revoke-permission-to');
});
