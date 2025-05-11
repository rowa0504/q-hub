@extends('layouts.app')

@section('title', 'Reported User Content')

@section('content')
<div class="container">
    <h4 class="mb-4">
        <i class="fa-solid fa-user-shield me-2"></i>Content by {{ $user->name ?? 'Deleted User' }}
    </h4>

    <div class="mb-4">
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <ul class="nav nav-tabs mb-3" id="contentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts" type="button">Posts</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button">Comments</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="answers-tab" data-bs-toggle="tab" data-bs-target="#answers" type="button">Answers</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat" type="button">Chat Messages</button>
        </li>
    </ul>

    <div class="tab-content border rounded p-3 bg-white" id="contentTabsContent">
        {{-- Posts --}}
        <div class="tab-pane fade show active" id="posts" role="tabpanel">
            <h5>Posts</h5>
            @forelse ($posts as $post)
                <div class="border-bottom py-2">
                    <strong>{{ $post->title }}</strong>
                    <p class="mb-1 text-muted">{{ $post->created_at->format('Y-m-d H:i') }}</p>
                    <p>{{ Str::limit($post->body, 100) }}</p>
                </div>
            @empty
                <p class="text-muted">No posts found.</p>
            @endforelse
        </div>

        {{-- Comments --}}
        <div class="tab-pane fade" id="comments" role="tabpanel">
            <h5>Comments</h5>
            @forelse ($comments as $comment)
                <div class="border-bottom py-2">
                    <p class="mb-1 text-muted">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                    <p>{{ $comment->body }}</p>
                </div>
            @empty
                <p class="text-muted">No comments found.</p>
            @endforelse
        </div>

        {{-- Answers --}}
        <div class="tab-pane fade" id="answers" role="tabpanel">
            <h5>Answers</h5>
            @forelse ($answers as $answer)
                <div class="border-bottom py-2">
                    <p class="mb-1 text-muted">{{ $answer->created_at->format('Y-m-d H:i') }}</p>
                    <p>{{ $answer->body }}</p>
                </div>
            @empty
                <p class="text-muted">No answers found.</p>
            @endforelse
        </div>

        {{-- Chat Messages --}}
        <div class="tab-pane fade" id="chat" role="tabpanel">
            <h5>Chat Messages</h5>
            @forelse ($chatMessages as $message)
                <div class="border-bottom py-2">
                    <p class="mb-1 text-muted">{{ $message->created_at->format('Y-m-d H:i') }}</p>
                    <p>{{ $message->body }}</p>
                </div>
            @empty
                <p class="text-muted">No chat messages found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
