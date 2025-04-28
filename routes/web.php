<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SocialLoginController;


Auth::routes();

Route::get('/login/{provider}', [SocialLoginController::class, 'redirectToProvider'])->name('social.login');
Route::get('/login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    // Post route
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PostController::class, 'delete'])->name('delete');
    });

    // Like route
    Route::group(['prefix' => 'like', 'as' => 'like.'], function () {
        Route::post('/{id}/store', [LikeController::class, 'store'])->name('store');
        Route::delete('/{id}/delete', [LikeController::class, 'delete'])->name('delete');
    });

    // Comment route
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {
        Route::post('/{id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
    });

    // Profile route
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/{id}', [ProfileController::class, 'show'])->name('show');
    });

    // カテゴリー別のroute
    // Event route
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/{id}', [EventController::class, 'show'])->name('show');
        Route::get('/api/events', [EventController::class, 'indexCalendar'])->name('indexCalendar');
    });

    // Food route
    Route::group(['prefix' => 'food', 'as' => 'food.'], function () {
        Route::get('/', [FoodController::class, 'index'])->name('index');
        Route::get('/{id}', [FoodController::class, 'show'])->name('show');
    });

    // Item route
    Route::group(['prefix' => 'item', 'as' => 'item.'], function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::get('/{id}', [ItemController::class, 'show'])->name('show');
    });

    // Travel route
    Route::group(['prefix' => 'travel', 'as' => 'travel.'], function () {
        Route::get('/', [TravelController::class, 'index'])->name('index');
        Route::get('/{id}', [TravelController::class, 'show'])->name('show');
    });

    // Transportation route
    Route::group(['prefix' => 'transportation', 'as' => 'transportation.'], function () {
        Route::get('/', [TransportationController::class, 'index'])->name('index');
        Route::get('/{id}', [TransportationController::class, 'show'])->name('show');
    });

    // Question route
    Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::get('/{id}', [QuestionController::class, 'show'])->name('show');
    });

    // Admin route
    // Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    //     Route::get('/users', [AdminController::class, 'users'])->name('users');
    //     Route::get('/foods', [AdminController::class, 'foods'])->name('foods');
    //     Route::get('/events', [AdminController::class, 'events'])->name('events');
    //     Route::get('/items', [AdminController::class, 'items'])->name('items');
    //     Route::get('/travels', [AdminController::class, 'travels'])->name('travels');
    //     Route::get('/transportations', [AdminController::class, 'transportations'])->name('transportations');
    // });


    //////////////////江上専用テストルートは下です////////////////////////////////////////////////////////////////////////
    Route::get('/admin/users', function () {
        return view('admin.users.index');
    });
    Route::get('/admin/foods', function () {
        return view('admin.foods.index');
    });

    Route::get('/questions/{id}', function ($id) {
        return view('posts.categories.questions.index', ['id' => $id]);
    });

    Route::get('/questions/show/{id}', [QuestionController::class, 'show'])->name('posts.categories.questions.show');


    //Profile//
    Route::get('/profile/edit/{id}', function ($id) {
        return view('profile.edit', ['id' => $id]);
    });
    //////////////////////////////江上専用テストデータはここまでです///////////////////////////////////////////

});
