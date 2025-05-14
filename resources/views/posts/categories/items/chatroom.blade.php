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
                                data-bs-toggle="modal" data-bs-target="#reportChatModal-{{ $message->id }}" data-message-id="{{ $message->id }}">
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

@foreach ($all_message as $message)
<!-- Report Comment Modal -->
    <div class="modal fade" id="reportChatModal-{{ $message->id }}" tabindex="-1" aria-labelledby="reportCommentModalLabel-{{ $message->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger" id="reportModalLabel">Report this post?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('report.store', $message->id) }}" method="POST">
                    @csrf

                    <input type="text" hidden name="reportable_type" value="App\Models\ChatMessage">
                    <div class="modal-body text-start">
                        @foreach($all_report_reasons as $report_reason )
                        <div class="form-check mb-2">
                            <input class="form-check-input me-3" type="checkbox" name="reason[]" value="{{ $report_reason->id }}" id="{{ $report_reason->name }}">
                            <label class="form-check-label" for="{{ $report_reason->name }}">{{ $report_reason->name }}</label>
                        </div>
                        @endforeach

                        @error('reason')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="modal-footer border-0 d-flex justify-content-center">
                        <span class="text-muted text-start">* You can choose multiple options</span>
                        <button type="submit" class="btn btn-danger w-100">Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

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

@if (session('open_modal'))
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const modalId = '{{ session('open_modal') }}';
            const targetModal = document.getElementById(modalId);
            if (targetModal) {
                const bsModal = new bootstrap.Modal(targetModal);
                bsModal.show();
            }
        });
    </script>
@endif
