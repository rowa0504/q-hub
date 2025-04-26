<div class="card w-100">
    {{-- 投稿ヘッダー --}}
    <div class="d-flex align-items-center border-bottom mb-2 p-2">
        <a href="{{ route('profile.show', $post->user->id) }}">
            @if ($post->user->avatar)
                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="rounded-circle avatar-sm">
            @else
                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
            @endif
        </a>
        <strong class="mx-2">{{ $post->user->name }}</strong>

        <div class="ms-auto position-relative">
            <i class="fas fa-ellipsis-h" style="cursor:pointer;" data-bs-toggle="dropdown"></i>
            <ul class="dropdown-menu dropdown-menu-end">
                @if (Auth::id() === $post->user_id)
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-{{ $post->id }}"><i class="fa-solid fa-trash"></i>
                            Delete</a></li>
                    <li><button class="dropdown-item text-warning btn-edit" data-id="{{ $post->id }}"
                            data-bs-toggle="modal" data-bs-target="#edit-form-{{ $post->id }}"><i
                                class="fa-solid fa-pen-to-square"></i> Edit</button></li>
                @else
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#reportModal-{{ $post->id }}"><i class="fa-solid fa-flag"></i>
                            Report</a></li>
                @endif
            </ul>
        </div>
    </div>

    {{-- 投稿画像 --}}
    <a href="{{ $post->getCategoryRoute() }}">
        <img src="{{ $post->image }}" class="img-fluid img-thumbnail" alt="Post Image">
    </a>

    <div class="card-body">
        {{-- いいね・コメントアクション --}}
        <div class="d-flex align-items-center mb-2">
            {{-- いいね --}}
            <div class="me-3 d-flex align-items-center">
                @if ($post->isLiked())
                    <form action="{{ route('like.delete', $post->id) }}" method="post"
                        class="d-flex align-items-center">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm p-0 border-0 bg-transparent d-flex align-items-center">
                            <i class="fa-solid fa-heart text-danger"></i>
                        </button>
                        <span class="ms-1">{{ $post->likes->count() }}</span>
                    </form>
                @else
                    <form action="{{ route('like.store', $post->id) }}" method="post"
                        class="d-flex align-items-center">
                        @csrf
                        <button class="btn btn-sm p-0 border-0 bg-transparent d-flex align-items-center">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <span class="ms-1">{{ $post->likes->count() }}</span>
                    </form>
                @endif
            </div>

            {{-- コメントボタン --}}
            <div class="me-3">
                <span data-bs-toggle="modal" data-bs-target="#commentsModal-{{ $post->id }}"
                    style="cursor:pointer;">
                    <i class="fa-regular fa-comment"></i>
                </span>
                <span>{{ $post->comments->count() }}</span>
            </div>
        </div>

        {{-- 投稿本文 --}}
        <p class="mb-0">
            <a href="{{ route('profile.show', $post->user->id) }}"
                class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
            &nbsp;
            <span class="fw-light">{{ $post->description }}</span>
        </p>
        <p class="text-uppercase text-muted small mb-0">{{ $post->created_at->format('M d, Y') }}</p>
    </div>
</div>

{{-- 投稿削除モーダル --}}
@include('posts.components.modals.comment-modal', ['post' => $post])

{{-- 投稿編集モーダル --}}

