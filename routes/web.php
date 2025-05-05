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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\AnswerController;


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
        Route::patch('/{post_id}/{id}', [CommentController::class, 'update'])->name('update');
    });

    // Answer route
    Route::group(['prefix' => 'answer', 'as' => 'answer.'], function () {
        Route::post('/store', [AnswerController::class, 'store'])->name('store');
        Route::post('/{answer}/best', [AnswerController::class, 'markBest'])->name('best');

    });


    // Profile route
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [ProfileController::class, 'update'])->name('update');
        Route::get('/{id}', [ProfileController::class, 'show'])->name('show');
    });

    // カテゴリー別のroute
    // Event route
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/{id}/show', [EventController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'participation','as' => 'participation.'], function(){
        Route::post('/{id}/store', [ParticipationController::class, 'store'])->name('store');
        Route::delete('/{id}/delete', [ParticipationController::class, 'delete'])->name('delete');
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

    // Chatroom route
    Route::group(['prefix' => 'chatRoom', 'as' => 'chatRoom.'], function () {
        Route::get('/{id}/start', [ChatRoomController::class, 'start'])->name('start');
        Route::get('/{id}/show', [ChatRoomController::class, 'show'])->name('show');
        Route::post('/{id}/leave', [ChatRoomController::class, 'leave'])->name('leave');

        //Chat Message route
        Route::post('/{id}/messages/store', [ChatMessageController::class, 'store'])->name('messages.store');
        Route::get('/{id}/messages/index', [ChatMessageController::class, 'index'])->name('messages.index');
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
    Route::group(['prefix' => 'question', 'as' => 'question.'], function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::get('/{id}', [QuestionController::class, 'show'])->name('show');
    });


    // Report route
    Route::post('/posts/{id}/report', [ReportController::class, 'store'])->name('posts.report');


    // Admin route
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/foods', [AdminController::class, 'foods'])->name('foods');
        Route::get('/events', [AdminController::class, 'events'])->name('events');
        Route::get('/items', [AdminController::class, 'items'])->name('items');
        Route::get('/travels', [AdminController::class, 'travels'])->name('travels');
        Route::get('/transportations', [AdminController::class, 'transportations'])->name('transportations');
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/users/{user}/activate', [AdminController::class, 'activate'])->name('users.activate');
        Route::delete('/users/{user}/deactivate', [AdminController::class, 'deactivate'])->name('users.deactivate');
    });


    //////////////////江上専用テストルートは下です////////////////////////////////////////////////////////////////////////

    Route::post('/answers/{answer}/best', function () {
        return back();
    })->name('answers.best');

    //////////////////////////////江上専用テストデータはここまでです///////////////////////////////////////////

});
