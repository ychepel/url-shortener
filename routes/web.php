<?php

use App\Http\Controllers\Api\v1\UrlShortenerController;
use App\Http\Controllers\UrlShortenerWebController;
use Illuminate\Support\Facades\Route;

Route::controller(UrlShortenerWebController::class)->group(function () {
    Route::get('/', 'create')->name('url.create');
    Route::get('/shorten', 'create');
    Route::post('/shorten', 'store')->name('url.shorten');
});

Route::get('/s/{shortCode}', [UrlShortenerController::class, 'redirect']);
