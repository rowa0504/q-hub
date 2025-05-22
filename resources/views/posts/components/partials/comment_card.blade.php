<div class="d-flex justify-content-between align-items-start border-bottom py-2 w-100">
    <img src="{{ $comment->user->avatar }}" class="rounded-circle me-2" width="40" height="40"
        onerror="this.src='{{ asset('images/user_icon.png') }}';">
    <div class="flex-grow-1">
        <div class="d-flex justify-content-between">
            <strong>{{ $comment->user->name }}</strong>
            @if (Auth::id() === $comment->user_id)
                {{-- 編集・削除 --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h text-muted"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item text-warning" onclick="editComment({{ $comment->id }})">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger" onclick="deleteComment({{ $comment->id }})">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </li>
                    </ul>
                </div>
            @else
                {{-- 通報 --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h text-muted"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item text-danger" data-bs-toggle="modal"
                               data-bs-target="#reportCommentModal-{{ $comment->id }}">
                                <i class="fa-solid fa-flag me-1"></i> Report
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>

        <!-- 通常表示 -->
        <p class="mb-1" id="comment-body-{{ $comment->id }}">{{ $comment->body }}</p>

        <!-- 編集フォーム -->
        <form class="d-none" id="edit-form-{{ $comment->id }}"
              onsubmit="submitEditComment(event, {{ $comment->id }}, {{ $comment->post_id }})">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="body" value="{{ $comment->body }}" required>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit({{ $comment->id }})">Cancel</button>
            </div>
        </form>
    </div>
</div>
