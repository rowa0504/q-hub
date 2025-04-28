@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="container-fluid py-3">
    <div class="row justify-content-center align-items-start">

        <!-- メインコンテンツ -->
        <div class="col-12 col-md-9">

            <!-- プロフィール情報 -->
            <div class="mb-3 bg-light rounded p-3 text-center">
                <img src="{{ asset('images/Zinnbei_button.png') }}" class="rounded-circle mb-2" width="100" height="100" alt="avatar">
                <h5 class="fw-bold">Kerem Suer</h5>
                <p class="text-muted small">"Design is intelligence made visible."</p>
                <hr>
                <div class="text-start small d-inline-block">
                    <p><strong>Enrollment Period:</strong> Jun 15, 2024 – Jul 7, 2025</p>
                    <p><strong>Graduation Status:</strong> Graduated</p>
                    <p><strong>Posts:</strong> {{ $all_posts->count() }}</p>
                </div>
            </div>

            <!-- カテゴリフィルター -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Main Feed</h5>
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

            <!-- 投稿ループ -->
            <div class="container-fluid">
                <div class="row justify-content-center align-items-start mt-3">
                    <div class="col-12 col-md-9">
                        @forelse($all_posts as $post)
                            @include('posts.components.post-card', ['post' => $post])
                        @empty
                            <p>No posts available.</p>
                        @endforelse
                    </div>
                    <div class="col-md-3 d-none d-md-block ps-md-4">
                        @include("posts.components.sidebar-menu")
                    </div>
                </div>
            </div>

        </div>

        <!-- サイドバー（PCのみ） -->
        <div class="col-md-3 d-none d-md-block">
            @include('posts.components.sidebar-menu')
        </div>

    </div>
</div>

@endsection
