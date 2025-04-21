<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::group(["middlware"=>"auth"],function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


});
