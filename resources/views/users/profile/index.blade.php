@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center align-items-start mt-3">

        <!-- プロフィール情報：スマホで上、PCで右 -->
        <div class="col-12 col-md-3 order-1 order-md-2 ps-md-4 mb-3">
            <div class="bg-light rounded p-3 text-center">

                {{-- プロフィールアイコン --}}
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" class="rounded-circle mb-2 avatar-md" alt="{{ $user->name }}">
                @else
                    <div class="text-center">
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center mx-auto mb-2"
                            style="width: 150px; height: 150px;">
                            <i class="fa-solid fa-circle-user fa-10x text-secondary"></i>
                        </div>
                    </div>
                @endif

                {{-- 名前 --}}
                <h5 class="fw-bold">{{ $user->name }}</h5>

                {{-- 自己紹介 --}}
                <p class="text-muted small">
                    {{ $user->introduction ?? 'No introduction yet.' }}
                </p>

                <hr>

                {{-- ユーザー情報 --}}
                <div class="text-start small">
                    <p><strong>Enrollment Period:</strong><br>
                        {{ $user->enrollment_start ? \Carbon\Carbon::parse($user->enrollment_start)->format('M d, Y') : 'N/A' }}
                        {{ $user->enrollment_end ? \Carbon\Carbon::parse($user->enrollment_end)->format('M d, Y') : 'N/A' }}
                    </p>
                    <p><strong>Graduation Status:</strong><br>
                        {{ $user->graduation_status ?? 'Not set' }}
                    </p>
                    <p><strong>Posts:</strong> {{ $all_posts->count() }}</p>
                </div>

                {{-- 編集 or 通報ボタン --}}
                @if (Auth::id() === $user->id)
                    <div class="mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>
                    </div>
                @else
                    <div class="mt-3">
                        <a class="btn btn-sm btn-outline-danger w-100" data-bs-toggle="modal"
                            data-bs-target="#reportUserModal-{{ $user->id }}">
                            <i class="fa-solid fa-flag me-1"></i> Report this user?
                        </a>
                    </div>

                    @include('posts.components.modals.report-user-modal', ['user' => $user])
                @endif

            </div>
        </div>

        <!-- 投稿リスト：スマホで下、PCで左 -->
        <div class="col-12 col-md-9 order-2 order-md-1">
            @include('posts.components.modals.calendar-modal')
            {{-- 投稿リスト本体 --}}
            @forelse($all_posts as $post)
                @include('posts.components.post-card', ['post' => $post])
            @empty
                <p>No posts available.</p>
            @endforelse
        </div>

    </div>
</div>

@endsection
