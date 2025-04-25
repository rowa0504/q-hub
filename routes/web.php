<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');

    // Post route
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function(){
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PostController::class, 'delete'])->name('delete');
    });

    // Like route
    Route::group(['prefix' => 'like','as' => 'like.'], function(){
        Route::post('/{id}/store', [LikeController::class, 'store'])->name('store');
        Route::delete('/{id}/delete', [LikeController::class, 'delete'])->name('delete');
    });

    // Comment route
    Route::group(['prefix' => 'comment','as' => 'comment.'], function(){
        Route::post('/{id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
    });

    // Profile route
    Route::group(['prefix'=> 'profile','as' => 'profile.'], function(){
        Route::get('/{id}/show', [ProfileController::class, 'show'])->name('show');
    });


//////////////////江上専用テストルートは下です////////////////////////////////////////////////////////////////////////
Route::get('/admin/users', function () {return view('admin.users.index');});
Route::get('/admin/foods', function () {return view('admin.foods.index');});
Route::get('/questions', function () {return view('questions.index');});
Route::get('/questions/{id}', function ($id) {return view('questions.show', ['id' => $id]);});

//Profile//
Route::get('/profile/edit/{id}', function ($id) {return view('profile.edit', ['id' => $id]);});
//////////////////////////////江上専用テストデータはここまでです///////////////////////////////////////////

});
