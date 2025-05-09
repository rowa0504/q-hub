@extends('layouts.app')

@section('content')
<div class="container my-5 p-4 bg-white rounded shadow-sm">
    <h2 class="h4 fw-bold mb-4">
        <i class="fa-solid fa-comments me-2"></i>Chat Room: {{ $chatdate->post->title }}
    </h2>

    {{-- Participants --}}
    <div class="mb-4">
        <h5><i class="fa-solid fa-users me-2"></i>Participants ({{ $chatdate->users->count() }} / {{ $chatdate->post->max }})</h5>
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

    {{-- Chat Messages --}}
    <div class="border rounded p-3 mb-4 bg-light" style="height: 300px; overflow-y: auto;">
        @foreach ($all_message as $message)
            @php $isMe = auth()->check() && auth()->id() === $message->user_id; @endphp

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
                <div class="p-2 {{ $isMe ? 'bg-primary text-white' : 'bg-white' }} border rounded position-relative" style="max-width: 75%;">
                    <div class="d-flex justify-content-between mb-1">
                        <strong>{{ $message->user->name }}</strong>
                        <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                    </div>
                    <p class="mb-0">{{ $message->body }}</p>

                    {{-- Report Button --}}
                    @if (!$isMe)
                        <button class="btn btn-sm btn-link position-absolute bottom-0 end-0 me-2 mb-1 p-0 text-danger"
                                data-bs-toggle="modal" data-bs-target="#reportModal" data-message-id="{{ $message->id }}">
                            <i class="fa-solid fa-flag"></i>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Message Form --}}
    <form action="{{ route('chatRoom.messages.store', $chatdate->id) }}" method="POST" class="mb-3">
        @csrf
        <div class="input-group">
            <textarea name="body" rows="2" class="form-control" placeholder="Enter your message..." required></textarea>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-paper-plane me-1"></i>Send
            </button>
        </div>
    </form>

    {{-- Leave Button --}}
    <form action="{{ route('chatRoom.leave', $chatdate->id) }}" method="POST" onsubmit="return confirmLeave();">
        @csrf
        <button type="submit" class="btn btn-outline-danger me-2">
            <i class="fa-solid fa-door-open me-1"></i>Leave this chat room
        </button>
    </form>

    {{-- Save and Exit --}}
    <a href="{{ route('item.index') }}">
        <button class="btn btn-secondary mt-2">
            <i class="fa-solid fa-save me-1"></i>Save and exit
        </button>
    </a>
</div>

{{-- Report Modal --}}
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="#">
            @csrf
            <input type="hidden" name="message_id" id="reportMessageId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">
                        <i class="fa-solid fa-flag me-2 text-danger"></i>Report Message
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="reason" class="form-label">Reason for reporting:</label>
                    <textarea name="reason" id="reason" rows="3" class="form-control" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    function confirmLeave() {
        return confirm("If you leave this room, other users may enter instead of you.\nAre you sure?");
    }

    // モーダルにメッセージIDを渡す
    var reportModal = document.getElementById('reportModal');
    reportModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var messageId = button.getAttribute('data-message-id');
        document.getElementById('reportMessageId').value = messageId;
    });
</script>
@endsection
