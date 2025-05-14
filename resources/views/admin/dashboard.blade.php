@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        {{-- Users --}}
        <div class="col">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-users fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Users</h5>
                    <p class="h4">{{ $user_count }}</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                </div>
            </div>
        </div>

        {{-- Posts --}}
        <div class="col">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-newspaper fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Posts</h5>
                    <p class="h4">{{ $post_count }}</p>
                    <a href="{{ route('admin.posts') }}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                </div>
            </div>
        </div>

        {{-- Comments --}}
        <div class="col">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-comments fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Comments</h5>
                    <p class="h4">{{ $comments_count }}</p>
                    <a href="{{ route('admin.comments') }}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                </div>
            </div>
        </div>

        {{-- Answers --}}
        <div class="col">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-question fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Answers</h5>
                    <p class="h4">{{ $answers_count ?? '-' }}</p>
                    <a href="{{ route('admin.answers') }}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                </div>
            </div>
        </div>

        {{-- ChatMessages --}}
        <div class="col">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-brands fa-rocketchat fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">ChatMessages</h5>
                    <p class="h4">{{ $chatMessage_count ?? '-' }}</p>
                    <a href="{{ route('admin.chatMessages') }}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                </div>
            </div>
        </div>

        {{-- Reports --}}
        <div class="col">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-flag fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Reports</h5>
                    <p class="h4">{{ $reports_count ?? '-' }}</p>
                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                </div>
            </div>
        </div>
    </div>
@endsection
