<?php

use App\Http\Controllers\UrlShortenerController;
use App\Http\Controllers\UrlShortenerWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UrlShortenerWebController::class, 'create'])->name('url.create');
Route::post('/shorten', [UrlShortenerWebController::class, 'store'])->name('url.shorten');

Route::get('/s/{shortCode}', [UrlShortenerController::class, 'redirect']);
