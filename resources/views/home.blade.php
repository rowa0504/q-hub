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

<div class="container-fluid">
    <div class="row justify-content-center align-items-start mt-3">
      <!-- 投稿一覧 -->
      <div class="col-12 col-md-9">
        @foreach($posts as $post)
          @include('components.post-card', ['post' => $post])
        @endforeach
      </div>

      <!-- メニュー（PCのみ表示） -->
      <div class="col-md-3 d-none d-md-block ps-md-4">
        @include('components.sidebar-menu')
      </div>
    </div>
  </div>
</div>

<!-- スマホ用ハンバーガーボタン -->
<button class="btn d-md-none position-fixed hamburger-menu" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>


<!-- スマホ用サイドバー -->
<div class="sidebar d-md-none" id="mobileSidebar">
  <div class="d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('storage/images/Zinnbei1.png') }}" alt="icon"
            style="width: auto; height: 100px;">
    </a>
    <div class="close-btn" onclick="toggleSidebar()">
      <i class="fas fa-times"></i>
    </div>
  </div>
  @include('components.sidebar-menu')
</div>

<script>
  function toggleSidebar() {
    document.getElementById('mobileSidebar').classList.toggle('show');
  }
</script>
@endsection
