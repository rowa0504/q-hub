@extends('layouts.app')

@section('content')
    <div class="container my-5 p-4 bg-white rounded shadow-sm">

        <h2 class="h4 fw-bold mb-4">Chat Room: {{ $chatdate->post->title }}</h2>

        {{-- Participants --}}
        <div class="mb-4">
            <h5 class="mb-2">Participants ({{ $chatdate->users->count() }} / {{ $chatdate->post->max }})</h5>
            <ul class="ps-3">
                @foreach ($chatdate->users as $user)
                    <li>{{ $user->name }}</li>
                @endforeach
            </ul>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Messages --}}
        <div class="border rounded p-3 mb-4 bg-light" style="height: 300px; overflow-y: auto;">
            @foreach ($all_message as $message)
                @php
                    $isMe = auth()->check() && auth()->id() === $message->user_id;
                @endphp

                <div class="d-flex mb-3 {{ $isMe ? 'flex-row-reverse text-end' : '' }}">
                    {{-- Avatar --}}
                    @if ($message->user->avatar)
                        <img src="{{ $message->user->avatar }}" alt="avatar"
                            class="rounded-circle {{ $isMe ? 'ms-2' : 'me-2' }}"
                            style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-circle-user fa-2x text-secondary {{ $isMe ? 'ms-2' : 'me-2' }}"></i>
                    @endif

                    {{-- Message Bubble --}}
                    <div class="p-2 {{ $isMe ? 'bg-primary text-white' : 'bg-white' }} border rounded"
                        style="max-width: 75%;">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>{{ $message->user->name }}</strong>
                            <small class="text-muted ms-2">{{ $message->created_at->format('H:i') }}</small>
                        </div>
                        <p class="mb-0">{{ $message->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Message Form --}}
        <form action="{{ route('chatRoom.messages.store', $chatdate->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group">
                <textarea name="body" rows="2" class="form-control" placeholder="Enter your message..." required></textarea>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>

        {{-- Leave Button --}}
        <form action="{{ route('chatRoom.leave', $chatdate->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link text-danger p-0">Leave this chat room</button>
        </form>

    </div>
@endsection
