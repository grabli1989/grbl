<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/sms-report-callback', function (Request $request) {
    logger(PHP_EOL.PHP_EOL.'### SMS REPORT ###');
    logger($request);
    logger(PHP_EOL.PHP_EOL.'##################');
})->withoutMiddleware('userIsConfirmed')->name('sms.report.callback');
