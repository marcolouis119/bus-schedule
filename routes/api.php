<?php

use App\Http\Controllers\BusController;
use App\Models\Route; //

// API Определение маршрутов 
Route::get('/find-bus', [BusController::class, 'findBus']);
Route::post('/routes/{routeId}/edit', [BusController::class, 'editRoute']);