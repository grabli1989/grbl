<?php

use Illuminate\Support\Facades\Route;
use User\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::withoutMiddleware('userIsConfirmed')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::match(['post', 'option'], '/user', [AuthController::class, 'user'])->name('user');
        Route::match(['post', 'option'], '/refresh', [AuthController::class, 'refresh'])->name('refresh');

        Route::match(['post', 'option'], '/confirmation', [AuthController::class, 'confirmation'])
            ->name('confirmation');
    });

    Route::match(['post', 'option'], '/register', [AuthController::class, 'register'])->name('register');
    Route::match(['post', 'option'], '/login', [AuthController::class, 'login'])->name('login');
    Route::match(['post', 'option'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::match(['post', 'option'], '/reset-password', [AuthController::class, 'resetPassword'])
        ->name('reset-password');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::match(['post', 'option'], '/update-password', [AuthController::class, 'updatePassword'])
        ->name('update-password');

    Route::match(['post', 'option'], '/user-roles', [AuthController::class, 'userRoles'])->name('user-roles');

    Route::match(['post', 'option'], '/assignment-roles', [AuthController::class, 'assignmentRoles'])->name('assignment-roles');
});
