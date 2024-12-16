<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;

Route::get('/', [RouteController::class, 'index'])
    ->name('index');

Route::get('/api/find-bus', [RouteController::class, 'find'])
    ->name('api.find-bus');

Route::patch('/api/update-bus', [RouteController::class, 'update'])
    ->name('api.update-bus');
