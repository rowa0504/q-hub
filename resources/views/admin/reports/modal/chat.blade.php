<!-- admin/reports/modal/chat.blade.php -->
<div class="modal fade" id="chatDetailModal-{{ $report->id }}" tabindex="-1"
    aria-labelledby="chatDetailModalLabel-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="chatDetailModalLabel-{{ $report->id }}">Reported Chat Message Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                {{-- チャットメッセージ本体 --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">
                            Message by: {{ $report->reportable->user->name ?? 'Unknown' }}
                        </h6>
                        <p class="card-text">
                            {{ $report->reportable->body }}
                        </p>
                    </div>
                </div>

                {{-- 投稿情報とチャットルーム名（postリレーションなし対応） --}}
                @php
                    $chatRoom = $report->reportable->chatRoom;
                    $post = $chatRoom?->post;
                @endphp

                @if ($post)
                    {{-- Related Post（文字自体にリンク） --}}
                    <div class="mb-3">
                        <a href="{{ $post->getCategoryRoute() }}" class="text-decoration-none fw-bold" target="_blank">
                            <i class="fa-solid fa-file-lines me-1"></i>
                            Related Post
                        </a>
                    </div>

                    {{-- 投稿説明文 --}}
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <div class="border p-2 rounded bg-white">
                            {{ $post->description ?? 'No description provided.' }}
                        </div>
                    </div>

                    {{-- チャットルーム名 --}}
                    <div class="mb-3">
                        <strong>Chat Room:</strong>
                        <a href="{{ route('chatRoom.show', $chatRoom->id) }}" class="text-decoration-none" target="_blank">
                            <i class="fa-solid fa-comments me-1"></i>
                            {{ $post->title ?? 'This post' }}'s Chat Room
                        </a>
                    </div>
                @else
                    <div class="mb-3 text-danger">
                        <strong>Related Post:</strong> Not found or disconnected.
                    </div>
                @endif
            </div>

            <div class="modal-footer bg-white d-flex justify-content-between">
                <div>
                    <small class="text-muted">Message ID: {{ $report->reportable->id }}</small>
                </div>
                <div>
                    <form action="{{ route('admin.chatMessages.deactivate', $report->reportable->id) }}"
                        method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can me-1"></i> Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
