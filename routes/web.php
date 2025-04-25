<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function(){
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PostController::class, 'delete'])->name('delete');
    });


//////////////////江上専用テストルートは下です////////////////////////////////////////////////////////////////////////
Route::get('/profile', function () {return view('profile.show');}); //→江上views/profile/show.blade.phpのため仮作成
Route::get('/admin/users', function () {return view('admin.users.index');});
Route::get('/admin/foods', function () {return view('admin.foods.index');});
Route::get('/questions', function () {return view('questions.index');});
Route::get('/questions/{id}', function ($id) {return view('questions.show', ['id' => $id]);});
//////////////////////////////江上専用テストデータはここまでです///////////////////////////////////////////






});
