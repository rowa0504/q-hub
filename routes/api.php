<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::middleware('api')->group(function () {
    Route::get('/events', [EventController::class, 'indexCalendar']);
    // Route::post('/events', [EventController::class, 'store']);
});
