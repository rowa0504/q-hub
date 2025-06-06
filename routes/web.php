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
use App\Http\Controllers\WantedItemController;
use App\Http\Controllers\ReportReasonController;
use App\Http\Controllers\GuestPostController;

Auth::routes();

Route::get('/guest', [GuestPostController::class, 'index'])->name('guest.index');

Route::get('/login/{provider}', [SocialLoginController::class, 'redirectToProvider'])->name('social.login');
Route::get('/login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    // Post route
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PostController::class, 'delete'])->name('delete');
    });

    // like route
    Route::post('/posts/{post_id}/like-toggle', [LikeController::class, 'likeToggle'])->name('posts.likeToggle');

    // Comment route
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {
        Route::post('/{post_id}', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
        Route::patch('/{post_id}/{id}', [CommentController::class, 'update'])->name('update');
    });

    // Answer route
    Route::group(['prefix' => 'answer', 'as' => 'answer.'], function () {
        Route::post('/store', [AnswerController::class, 'store'])->name('store');
        Route::post('/{answer}/best', [AnswerController::class, 'markBest'])->name('best');
        Route::patch('/answers/{id}', [AnswerController::class, 'update'])->name('update');
        Route::delete('/answers/{id}', [AnswerController::class, 'destroy'])->name('destroy');
    });


    // Profile route
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/{id}/index', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [ProfileController::class, 'update'])->name('update');
        // Route::get('/{id}', [ProfileController::class, 'show'])->name('show');
        Route::get('/search', [ProfileController::class, 'search'])->name('search');
    });

    // カテゴリー別のroute
    // Event route
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/{id}/show', [EventController::class, 'show'])->name('show');
        Route::get('/search', [EventController::class, 'search'])->name('search');
    });

    // Participation route
    Route::post('/posts/{post_id}/participation-toggle', [ParticipationController::class, 'participationToggle'])
        ->name('posts.participationToggle');
    // routes/web.php
    Route::get('/posts/{post}/participants', [ParticipationController::class, 'getParticipants']);



    // Food route
    Route::group(['prefix' => 'food', 'as' => 'food.'], function () {
        Route::get('/', [FoodController::class, 'index'])->name('index');
        Route::get('/search', [FoodController::class, 'search'])->name('search');
    });

    // Item route
    Route::group(['prefix' => 'item', 'as' => 'item.'], function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::get('/search', [ItemController::class, 'search'])->name('search');
    });

    // Wanted Item route
    Route::group(['prefix' => 'wantedItem', 'as' => 'wantedItem.'], function () {
        Route::post('/store', [WantedItemController::class, 'store'])->name('store');
    });

    // Chatroom route
    Route::group(['prefix' => 'chatRoom', 'as' => 'chatRoom.'], function () {
        Route::get('/{id}/start', [ChatRoomController::class, 'start'])->name('start');
        Route::get('/{id}/show', [ChatRoomController::class, 'show'])->name('show');
        Route::post('/{id}/leave', [ChatRoomController::class, 'leave'])->name('leave');

        //Chat Message route
        Route::post('/{id}/messages/store', [ChatMessageController::class, 'store'])->name('messages.store');
    });

    // Travel route
    Route::group(['prefix' => 'travel', 'as' => 'travel.'], function () {
        Route::get('/', [TravelController::class, 'index'])->name('index');
        Route::get('/search', [TravelController::class, 'search'])->name('search');
    });

    // Transportation route
    Route::group(['prefix' => 'transportation', 'as' => 'transportation.'], function () {
        Route::get('/', [TransportationController::class, 'index'])->name('index');
        Route::get('/search', [TransportationController::class, 'search'])->name('search');
    });

    // Question route
    Route::group(['prefix' => 'question', 'as' => 'question.'], function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::get('/search', [QuestionController::class, 'search'])->name('search');
    });


    // Report route
    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::post('/{id}/store', [ReportController::class, 'store'])->name('store');
    });

    // Admin route
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // ユーザーの状態変更
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{id}/activate', [AdminController::class, 'activate'])->name('users.activate');
        Route::delete('/users/{id}/deactivate', [AdminController::class, 'deactivate'])->name('users.deactivate');


        // 投稿の状態変更
        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        Route::get('/posts/{id}/show', [AdminController::class, 'show'])->name('posts.show');
        Route::delete('/posts/{id}/deactivate', [AdminController::class, 'deactivatePost'])->name('posts.deactivate');
        Route::patch('/posts/{id}/activate', [AdminController::class, 'activatePost'])->name('posts.activate');


        // コメントの状態変更
        Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
        Route::patch('/comments/{id}/activate', [AdminController::class, 'activateComment'])->name('comments.activate');
        Route::delete('/comments/{id}/deactivate', [AdminController::class, 'deactivateComment'])->name('comments.deactivate');


        // いいねの状態変更
        Route::get('/answers', [AdminController::class, 'answers'])->name('answers');
        Route::delete('/answers/{id}/deactivate', [AdminController::class, 'deactivateAnswer'])->name('answers.deactivate');
        Route::patch('/answers/{id}/activate', [AdminController::class, 'activateAnswer'])->name('answers.activate');


        //chatMessage
        Route::get('/chatMessages', [AdminController::class, 'chatMessages'])->name('chatMessages');
        Route::patch('/chatMessages/{id}/activate', [AdminController::class, 'activateChatMessage'])->name('chatMessages.activate');
        Route::delete('/chatMessages/{id}/deactivate', [AdminController::class, 'deactivateChatMessage'])->name('chatMessages.deactivate');


        //reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/{id}/reportedUser', [AdminController::class, 'reportedUserContent'])->name('reportedUser');
        Route::patch('/reports/{id}/activate', [AdminController::class, 'activateReport'])->name('reports.activate');
        Route::delete('/reports/{id}/deactivate', [AdminController::class, 'deactivateReport'])->name('reports.deactivate');

        //warning
        Route::post('/{id}/storeMessage', [ReportController::class, 'storeMessage'])->name('storeMessage');
        Route::patch('/reports/{id}/update', [ReportController::class, 'updateReportMessage'])->name('updateReportMessage');
        Route::patch('/reports/{id}/delete', [ReportController::class, 'deleteReportMessage'])->name('deleteReportMessage');
        Route::patch('/{id}/close', [ReportController::class, 'close'])->name('close');
        Route::post('/{id}/dismissed', [ReportController::class, 'dismissed'])->name('dismissed');

        Route::get('/reportReasons/create', [ReportReasonController::class, 'create'])->name('reportReasons.create');
        Route::post('/reportReasons/store', [ReportReasonController::class, 'store'])->name('reportReasons.store');
        Route::patch('/reportReasons/{id}/update', [ReportReasonController::class, 'update'])->name('reportReasons.update');
        Route::delete('/reportReasons/{id}/delete', [ReportReasonController::class, 'destroy'])->name('reportReasons.delete');
    });
});
