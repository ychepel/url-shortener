<?php

use App\Http\Controllers\UrlShortenerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/s/{shortCode}', [UrlShortenerController::class, 'redirect']);
