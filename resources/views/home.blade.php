@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- ダミーデータ --}}
@php
$posts = collect([
    (object)[
        'id' => 1,
        'user' => (object)[
            'id' => 1,
            'name' => 'John Doe',
            'avatar' => 'https://t4.ftcdn.net/jpg/11/12/74/55/240_F_1112745523_f8Sd72Uxjlmh1FBUFYyOGrLCOoU0y4Dj.jpg',
        ],
        'image_url' => 'https://t4.ftcdn.net/jpg/01/33/06/89/240_F_133068958_OyHjztJTfc6i0Vzw0GTibNVWJUt77dhL.jpg',
        'description' => 'This is a beautiful sunflower blooming in summer.',
        'likes' => collect([1, 2, 3]),
        'comments' => collect([
            (object)['id' => 1, 'body' => 'Nice photo!'],
            (object)['id' => 2, 'body' => 'Amazing!'],
        ]),
        'categoryPost' => collect([
            (object)['category' => (object)['name' => 'Travel']],
            (object)['category' => (object)['name' => 'Nature']],
        ]),
        'created_at' => now(),
    ],
]);
@endphp

{{-- 投稿表示 + PCメニュー --}}
<div class="container-fluid">
    <div class="row justify-content-center align-items-start mt-3">
        <div class="col-12 col-md-9">
            @foreach($posts as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>
        <div class="col-md-3 d-none d-md-block ps-md-4">
            @include('components.sidebar-menu')
        </div>
    </div>
</div>

{{-- スマホ用ハンバーガー --}}
<button class="btn d-md-none position-fixed hamburger-menu" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

{{-- スマホ用オーバーレイ（背景を暗くする） --}}
<div id="sidebarOverlay" class="sidebar-overlay d-md-none" onclick="toggleSidebar()"></div>

{{-- スマホ用サイドバー --}}
<div class="sidebar-mobile d-md-none" id="mobileSidebar">
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/Zinnbei1.png') }}" alt="icon" style="height: 60px;">
        </a>
        <button class="btn btn-outline-secondary btn-sm" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="p-3">
        @include('components.sidebar-menu')
    </div>
</div>

{{-- スマホ用サイドバーのスタイル --}}
<script>
    function toggleSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const hamburger = document.querySelector('.hamburger-menu');

    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');

    // サイドバーが表示されたらハンバーガーを非表示に、非表示なら表示に
    if (sidebar.classList.contains('show')) {
        hamburger.style.display = 'none';
    } else {
        hamburger.style.display = 'block';
    }
}
</script>

@endsection
