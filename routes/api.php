<?php

use App\Http\Controllers\Api\v1\UrlShortenerController;
use Illuminate\Support\Facades\Route;

Route::post('/shorten', [UrlShortenerController::class, 'store']);
