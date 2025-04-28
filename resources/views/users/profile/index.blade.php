@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center align-items-start mt-3">

        <!-- 投稿リスト：左側（col-md-9） -->
        <div class="col-12 col-md-9">

            {{-- 投稿リストのヘッダー（左：タイトル、右：カテゴリフィルター） --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">{{ $user->name }}'s Posts</h5>
                <form method="GET" action="{{ url()->current() }}">
                    <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="event">📅 Event</option>
                        <option value="food">🍔 Food</option>
                        <option value="item">🎁 Item</option>
                        <option value="travel">📍 Travel</option>
                        <option value="transportation">🚗 Transportation</option>
                        <option value="question">❓ Question</option>
                    </select>
                </form>
            </div>

            {{-- 投稿リスト本体 --}}
            @forelse($all_posts as $post)
                @include('posts.components.post-card', ['post' => $post])
            @empty
                <p>No posts available.</p>
            @endforelse

        </div>

        <!-- プロフィール情報：右側（col-md-3） -->
        <div class="col-md-3 d-none d-md-block ps-md-4">
            <div class="bg-light rounded p-3 text-center">

                {{-- プロフィールアイコン --}}
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" class="rounded-circle mb-2" width="100" height="100" alt="{{ $user->name }}">
                @else
                    <img src="{{ asset('images/Zinnbei_button.png') }}" class="rounded-circle mb-2" width="100" height="100" alt="default avatar">
                @endif

                {{-- 名前 --}}
                <h5 class="fw-bold">{{ $user->name }}</h5>

                {{-- 自己紹介 --}}
                <p class="text-muted small">
                    {{ $user->introduction ?? 'No introduction yet.' }}
                </p>

                <hr>

                {{-- ユーザー情報（必要な場合） --}}
                <div class="text-start small">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    {{-- Enrollment Periodなどはもし使いたかったらカスタムで表示できる --}}
                    <p><strong>Posts:</strong> {{ $all_posts->count() }}</p>
                </div>

                {{-- ✏️ 編集ボタン --}}
                <div class="mt-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
