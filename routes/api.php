<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventCalendarController;
use App\Http\Controllers\LikeController;

Route::middleware('api')->group(function () {
    Route::get('/events', [EventCalendarController::class, 'index']);

    Route::post('/posts/{post}/like-toggle', [LikeController::class, 'likeToggle']);

});
