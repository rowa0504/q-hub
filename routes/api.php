<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventCalendarController;

Route::middleware('api')->group(function () {
    Route::get('/events', [EventCalendarController::class, 'index']);
});
