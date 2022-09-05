<?php

use Search\Http\Controllers\SearchController;

Route::match(['option', 'post'], '/search', [SearchController::class, 'search'])
    ->withoutMiddleware('userIsConfirmed')
    ->name('search');
