@extends('layouts.app')

@section('title', 'Event')

@section('content')

{{-- 投稿表示 + PCメニュー --}}
<div class="container-fluid">
    <button class="dropdown-item text-warning btn-edit" data-bs-toggle="modal" data-bs-target="#calendar">
        <i class="fa-solid fa-calendar-days text-info"></i>
    </button>
    @include('posts.components.modals.calendar-modal')

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


@endsection
