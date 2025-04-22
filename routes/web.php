<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::group(["middlware"=>"auth"],function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');});

//////////////////江上専用テストルートは下です////////////////////////////////////////////////////////////////////////
Route::get('/profile', function () {return view('profile.show');}); //→江上views/profile/show.blade.phpのため仮作成
Route::get('/admin/users', function () {
    $all_users = collect([
        (object) [
            'id' => 1,
            'name' => 'テストユーザー1',
            'email' => 'user1@example.com',
            'avatar' => null,
            'role' => '管理者',
            'created_at' => '2024-04-10 09:30:45',
            'is_active' => true
        ],
        (object) [
            'id' => 2,
            'name' => 'テストユーザー2',
            'email' => 'user2@example.com',
            'avatar' => null,
            'role' => '一般ユーザー',
            'created_at' => '2024-04-12 14:25:18',
            'is_active' => true
        ],
        (object) [
            'id' => 3,
            'name' => 'テストユーザー3',
            'email' => 'user3@example.com',
            'avatar' => null,
            'role' => '編集者',
            'created_at' => '2024-04-15 11:05:33',
            'is_active' => false
        ],
    ]);
    return view('admin.users.index', compact('all_users'));
});

//////////////////////////////江上専用テストデータはここまでです///////////////////////////////////////////






