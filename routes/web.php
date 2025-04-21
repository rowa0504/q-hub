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

Route::get('/profile', function () {return view('profile.show');}); //江上views/profile/show.blade.phpのため仮作成

