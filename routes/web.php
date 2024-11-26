<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/find-bus', [RouteController::class, 'find'])
    ->name('api.find-bus');