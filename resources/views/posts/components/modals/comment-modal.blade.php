<!-- コメントモーダル -->
<div class="modal fade" id="commentsModal-{{ $post->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- コメント追加フォーム -->
                <form action="{{ route('comment.store', $post->id) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="body" class="form-control form-control-sm"
                            placeholder="Add a comment..." required>
                        <button type="submit" class="btn btn-sm btn-primary">Post</button>
                    </div>
                    @error('body')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </form>

                <!-- コメント一覧 -->
                @foreach ($post->comments as $comment)
                    @if ($comment->user && !$comment->user->trashed())
                        <div class="d-flex justify-content-between align-items-start border-bottom py-2">
                            <div class="w-100">
                                <div class="d-flex align-items-center mb-1">
                                    <img src="{{ $comment->user->avatar }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/user_icon.png') }}';"
                                        alt="User Avatar" class="rounded-circle me-2" width="40" height="40">
                                    <a href="{{ route('profile.index', $comment->user->id) }}"
                                        class="text-decoration-none text-dark">
                                        <strong>{{ $comment->user->name }}</strong>
                                    </a>
                                </div>

                                {{-- 表示用 --}}
                                <p class="text-start mb-0" id="comment-body-{{ $comment->id }}">{{ $comment->body }}</p>

                                {{-- 編集用フォーム（初期は非表示） --}}
                                <form class="d-none" id="edit-form-{{ $comment->id }}"
                                    action="{{ route('comment.update', ['post_id' => $comment->post_id, 'id' => $comment->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group mb-2">
                                        <input type="text" name="body" class="form-control form-control-sm"
                                            value="{{ $comment->body }}" required>
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            onclick="cancelEdit({{ $comment->id }})">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <div class="dropdown ms-2">
                                <i class="fas fa-ellipsis-h" data-bs-toggle="dropdown" style="cursor:pointer;"></i>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if (Auth::id() === $comment->user_id)
                                        <li>
                                            <a href="#" class="dropdown-item text-warning"
                                                onclick="event.preventDefault(); editComment({{ $comment->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa-solid fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <button class="dropdown-item text-danger"
                                                onclick="showReportModal({{ $comment->id }})">
                                                <i class="fa-solid fa-flag"></i> Report
                                            </button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- 各コメント用の報告モーダル（モーダル外に配置） -->
@foreach ($post->comments as $comment)
    <div class="modal fade" id="reportCommentModal-{{ $comment->id }}" tabindex="-1"
        aria-labelledby="reportCommentModalLabel-{{ $comment->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">Report this comment?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('report.store', $comment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="reportable_type" value="App\Models\Comment">

                    <div class="modal-body text-start">
                        @foreach($all_report_reasons as $report_reason)
                            <div class="form-check mb-2">
                                <input class="form-check-input me-3" type="checkbox"
                                    name="reason[]" value="{{ $report_reason->id }}"
                                    id="reason-{{ $report_reason->id }}-{{ $comment->id }}">
                                <label class="form-check-label"
                                    for="reason-{{ $report_reason->id }}-{{ $comment->id }}">{{ $report_reason->name }}</label>
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

@push('scripts')
    <script>
        function editComment(commentId) {
            document.getElementById('comment-body-' + commentId).classList.add('d-none');
            document.getElementById('edit-form-' + commentId).classList.remove('d-none');
        }

        function cancelEdit(commentId) {
            document.getElementById('comment-body-' + commentId).classList.remove('d-none');
            document.getElementById('edit-form-' + commentId).classList.add('d-none');
        }

        function showReportModal(commentId) {
            const modalElement = document.getElementById('reportCommentModal-' + commentId);
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show(); // 子モーダルを表示
            } else {
                console.error("子モーダルが見つかりません");
            }
        }
    </script>
@endpush

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
