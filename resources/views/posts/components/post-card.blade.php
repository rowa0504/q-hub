<div class="card w-100">
    {{-- 投稿の詳細モーダル --}}
    <div class="d-flex align-items-center border-bottom mb-2">
        <img src="{{ $post->user->avatar ?? '' }}" class="rounded-circle me-2 avatar-sm" alt="Profile">
        <strong>{{ $post->user->name }}</strong>

        {{-- 投稿編集＆削除＆報告 --}}
        <div class="ms-auto position-relative">
            <i class="fas fa-ellipsis-h" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>

            <ul class="dropdown-menu dropdown-menu-end">
                @if (Auth::id() === $post->user_id)
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-{{ $post->id }}"><i class="fa-solid fa-trash"></i> Delete</a></li>
                    <li>
                        <button class="dropdown-item text-warning btn-edit" data-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#edit-form-4">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                    </li>
                @else
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#reportModal-{{ $post->id }}"><i class="fa-solid fa-flag"></i> Report</a></li>
                @endif
            </ul>
        </div>

        {{-- modal --}}
        @include('posts.components.modals.delete-modal', ['post' => $post])
        @include('posts.components.edit-forms.edit-form-event-modal', ['post' => $post])
        @include('posts.components.modals.report-modal', ['post' => $post])

    </div>

    <div class="container p-0">
        <a href="#">
            <img src="{{ $post->image }}" class="img-fluid img-thumbnail" alt="Post Image">
        </a>
    </div>

    <div class="card-body">
        <div class="row align-items-center flex-wrap">
            <div class="col-auto d-flex align-items-center gap-2">
                <!-- Likeボタン -->
                <form action="#" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm shadow-none p-0">
                        {{-- @if ($post->likedBy(Auth::user())) --}}
                        <i class="fa-solid fa-heart fa-lg text-danger"></i>
                        {{-- @else --}}
                        {{-- <i class="fa-regular fa-heart fa-lg"></i> --}}
              {{-- @endif --}}
                    </button>
                </form>

                <!-- Like数 -->
                <span data-bs-toggle="modal" data-bs-target="#likedUsersModal-{{ $post->id }}"
                    class="text-danger me-2" style="cursor:pointer;">
                    {{ $post->likes_count }}
                </span>

                <!-- コメントアイコン＋数 -->
                <span data-bs-toggle="modal" data-bs-target="#commentsModal-{{ $post->id }}"
                    style="cursor:pointer;">
                    <i class="fa-regular fa-comment fa-lg"></i>
                    {{ $post->comments_count }}
                </span>
            </div>

            <div class="col text-end">
                <span class="badge bg-secondary bg-opacity-50">{{ $post->category->name ?? 'Uncategorized' }}</span>
            </div>
        </div>

        <a href="#" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
        &nbsp;
        <p class="d-inline fw-light">
            {{-- {{ $post->caption }}</p> --}}
        <p class="text-uppercase text-muted small">{{ $post->created_at->format('M d, Y') }}</p>
    </div>
</div>
