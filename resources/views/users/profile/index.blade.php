@extends('layouts.app')

@section('title', 'Profile')

@section('content')

{{-- ダミー投稿データ --}}
@php
$all_posts = collect([
    (object)[
        'id' => 1,
        'user_id' => 1,
        'user' => (object)[
            'name' => 'Kerem Suer',
            'avatar' => asset('images/Zinnbei_button.png')
        ],
        'image' => 'https://placehold.co/600x400',
        'caption' => 'This is a caption for a post about food.',
        'created_at' => now(),
        'category' => (object)['name' => 'Food']
    ],
    (object)[
        'id' => 2,
        'user_id' => 2,
        'user' => (object)[
            'name' => 'Jane Doe',
            'avatar' => asset('images/Zinnbei_button.png')
        ],
        'image' => 'https://placehold.co/600x400',
        'caption' => 'Let’s go on a trip to Bohol!',
        'created_at' => now()->subDays(1),
        'category' => (object)['name' => 'Travel']
    ]
]);
@endphp

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
            @foreach ($all_posts as $post)
                <div class="card mb-3 w-100">
                    <div class="d-flex align-items-center border-bottom p-2">
                        <img src="{{ $post->user->avatar ?? '' }}" class="rounded-circle me-2" alt="Profile" width="32" height="32">
                        <strong>{{ $post->user->name }}</strong>

                        <div class="ms-auto position-relative">
                            <i class="fas fa-ellipsis-h" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (Auth::id() === $post->user_id)
                                    <li><a class="dropdown-item text-danger"><i class="fa-solid fa-trash"></i> Delete</a></li>
                                    <li><button class="dropdown-item text-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</button></li>
                                @else
                                    <li><a class="dropdown-item text-danger"><i class="fa-solid fa-flag"></i> Report</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="container p-0">
                        <a href="#">
                            <img src="{{ $post->image }}" class="w-100" alt="Post Image">
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center flex-wrap">
                            <div class="col-auto d-flex align-items-center gap-2">
                                <form action="#" method="post">
                                    @csrf
                                    <button class="btn btn-sm shadow-none p-0">
                                        <i class="fa-solid fa-heart fa-lg text-danger"></i>
                                    </button>
                                </form>
                                <span class="text-danger me-2" style="cursor:pointer;">12</span>
                                <span style="cursor:pointer;">
                                    <i class="fa-regular fa-comment fa-lg"></i> 3
                                </span>
                            </div>
                            <div class="col text-end">
                                <span class="badge bg-secondary bg-opacity-50">{{ $post->category->name ?? 'Uncategorized' }}</span>
                            </div>
                        </div>

                        <a href="#" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                        <p class="d-inline fw-light">{{ $post->caption ?? '' }}</p>
                        <p class="text-uppercase text-muted small">{{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- サイドバー（PCのみ） -->
        <div class="col-md-3 d-none d-md-block">
            @include('posts.components.sidebar-menu')
        </div>

    </div>
</div>

@endsection
