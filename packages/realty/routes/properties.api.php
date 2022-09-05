<?php

use Illuminate\Support\Facades\Route;
use Realty\Http\Controllers\PropertiesController;

Route::prefix('properties')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::match(['option', 'post'], '/pick-up', [PropertiesController::class, 'pickUp'])->name('properties.pick-up');
        Route::match(['option', 'post'], '/question-types', [PropertiesController::class, 'questionTypes'])->name('properties.question-types');

        Route::match(['option', 'post'], '/sets', [PropertiesController::class, 'sets'])->name('properties.sets');
        Route::match(['option', 'post'], '/create-set', [PropertiesController::class, 'createSet'])->name('properties.create-set');
        Route::match(['option', 'post'], '/update-set', [PropertiesController::class, 'updateSet'])->name('properties.update-set');
        Route::match(['option', 'post'], '/drop-set', [PropertiesController::class, 'dropSet'])->name('properties.drop-set');

        Route::match(['option', 'post'], '/questions', [PropertiesController::class, 'questions'])->name('properties.questions');
        Route::match(['option', 'post'], '/create-question', [PropertiesController::class, 'createQuestion'])->name('properties.create-question');
        Route::match(['option', 'post'], '/update-question', [PropertiesController::class, 'updateQuestion'])->name('properties.update-question');
        Route::match(['option', 'post'], '/drop-question', [PropertiesController::class, 'dropQuestion'])->name('properties.drop-question');

        Route::match(['option', 'post'], '/all', [PropertiesController::class, 'properties'])->name('properties.all');
        Route::match(['option', 'post'], '/create-property', [PropertiesController::class, 'createProperty'])->name('properties.create-property');
        Route::match(['option', 'post'], '/update-property', [PropertiesController::class, 'updateProperty'])->name('properties.update-property');
        Route::match(['option', 'post'], '/drop-property', [PropertiesController::class, 'dropProperty'])->name('properties.drop-property');
    });
});
