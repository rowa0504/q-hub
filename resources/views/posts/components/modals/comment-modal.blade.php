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

                        <!-- Report Comment Modal -->
                        <div class="modal fade" id="reportCommentModal-{{ $comment->id }}" tabindex="-1"
                            aria-labelledby="reportCommentModalLabel-{{ $comment->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reportCommentModalLabel-{{ $comment->id }}">Report Comment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to report this comment?</p>
                                        <!-- 仮のフォーム -->
                                        <form action="#" method="POST">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                            <div class="mb-3">
                                                <label for="reason-{{ $comment->id }}" class="form-label">Reason</label>
                                                <textarea name="reason" id="reason-{{ $comment->id }}" class="form-control"
                                                    rows="3" placeholder="Enter reason for reporting..." required></textarea>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-secondary me-2"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Report</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

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
            const parentModalElement = document.getElementById('commentsModal-{{ $post->id }}');
            const parentModal = new bootstrap.Modal(parentModalElement);

            // 親モーダルを非表示にする
            parentModal.hide();

            // 親モーダルが非表示になったことを確認し、少し遅延して子モーダルを表示
            setTimeout(() => {
                // 子モーダルを表示
                const modalElement = document.getElementById('reportCommentModal-' + commentId);
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show(); // 子モーダルを表示
                } else {
                    console.error("子モーダルが見つかりません");
                }
            }, 300); // 親モーダルの閉じるアニメーション時間を待つために遅延（300ms）
        }
    </script>
@endpush

