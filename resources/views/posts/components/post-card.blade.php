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
            {{-- カテゴリ --}}
            <div class="mb-3">
                <i class="fa-solid fa-tag"></i>
                <span class="ms-1 text-muted">{{ $post->category->name }}</span>
            </div>
            <i class="fas fa-ellipsis-h" style="cursor:pointer;" data-bs-toggle="dropdown"></i>
            <ul class="dropdown-menu dropdown-menu-end">
                @if (Auth::id() === $post->user_id)
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-{{ $post->id }}"><i class="fa-solid fa-trash"></i>
                            Delete</a></li>
                    <li>
                        <button class="dropdown-item text-warning btn-edit" data-id="{{ $post->id }}"
                            data-bs-toggle="modal" data-bs-target="#edit-form-{{ $post->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit
                        </button>
                    </li>
                @else
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#reportModal-{{ $post->id }}"><i class="fa-solid fa-flag"></i>
                            Report</a></li>
                @endif
            </ul>
        </div>
        {{-- modal --}}
        @include('posts.components.modals.delete-modal', ['post' => $post])
        @include('posts.components.edit-forms.edit-form-modal', ['post' => $post])
        @include('posts.components.modals.report-modal', ['post' => $post])
    </div>

    {{-- 投稿画像 --}}
    <a href="{{ $post->getCategoryRoute() }}">
        <img src="{{ $post->image }}" class="img-fluid" alt="Post Image">
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
                @if ($post->category_id == 6)
                    <!-- category_id が 6 のとき -->
                    <!-- アンサーアイコン -->
                    <span data-bs-toggle="modal" data-bs-target="#answerModal-{{ $post->id }}"
                        style="cursor:pointer;">
                        <i class="fa-solid fa-reply"></i> <!-- アンサーアイコン -->
                    </span>
                @else
                    <!-- コメントアイコン -->
                    <span data-bs-toggle="modal" data-bs-target="#commentsModal-{{ $post->id }}"
                        style="cursor:pointer;">
                        <i class="fa-regular fa-comment"></i> <!-- コメントアイコン -->
                    </span>
                @endif
                <span>{{ $post->comments->count() }}</span>
            </div>

        </div>



        {{-- Category-Specific Additional Information --}}
        @switch($post->category_id)
            @case(1)
                {{-- event --}}
                <div class="mt-2 fw-bold">
                    <p class="mb-1">Event: {{ $post->title ?? 'TBD' }}</p>
                    <p class="mb-1">
                        Start Date:
                        {{ $post->startdatetime ? \Carbon\Carbon::parse($post->startdatetime)->format('M d, Y H:i') : 'TBD' }}
                    </p>
                    <p class="mb-1">
                        End Date:
                        {{ $post->enddatetime ? \Carbon\Carbon::parse($post->enddatetime)->format('M d, Y H:i') : 'TBD' }}
                    </p>
                    <p class="mb-1">Max participants: {{ $post->max ?? 'TBD' }}</p>
                </div>
            @break

            @case(2)
                {{-- food --}}
                <div class="mt-2 fw-bold">
                    <p class="mb-1">Title: {{ $post->title ?? 'TBD' }}</p>
                    <p class="mb-1">Location: {{ $post->location ?? 'TBD' }}
                    <i class="fa-solid fa-location-dot icon-sm"></i>
                    </p>
                </div>
            @break

            @case(3)
                {{-- item --}}
                <div class="mt-2 fw-bold">
                    <p class="mb-1">Item name: {{ $post->title ?? 'TBD' }}</p>
                    <p class="mb-1">Max participants: {{ $post->max ?? 'TBD' }}</p>
                </div>
            @break

            @case(4)
                {{-- travel --}}
                <div class="mt-2 fw-bold">
                    <p class="mb-1">Title: {{ $post->title ?? 'TBD' }}</p>
                    <p class="mb-1">Location: {{ $post->location ?? 'TBD' }}
                        <i class="fa-solid fa-location-dot icon-sm"></i>
                    </p>
                </div>
            @break

            @case(5)
                {{-- transportation --}}
                <div class="mt-2 fw-bold">
                    <p class="mb-1">Title: {{ $post->title ?? 'TBD' }}</p>
                    <p class="mb-1">Fee: {{ $post->fee ?? 'TBD' }}₱</p>
                    <p class="mb-1">Departure: {{ $post->departure ?? 'TBD' }}</p>
                    <p class="mb-1">Destination: {{ $post->destination ?? 'TBD' }}</p>
                </div>
            @break

            @case(6)
                {{-- question --}}
                <div class="mt-2 fw-bold">
                    <p class="mb-1">Question: {{ $post->title ?? 'TBD' }}</p>
                </div>
            @break

            @default
                {{-- Default: No additional information --}}
        @endswitch

        {{-- 投稿本文 --}}
        <p class="mb-0">
            <span class="fw-bold">{{ $post->description }}</span>
        </p>
        <p class="text-uppercase text-muted small mb-0">{{ $post->created_at->format('M d, Y') }}</p>
    </div>
</div>

{{-- 投稿編集モーダル --}}
@include('posts.components.modals.edit-modal', ['post' => $post])
{{-- 投稿報告モーダル --}}
@include('posts.components.modals.report-modal', ['post' => $post])
{{-- 投稿削除確認モーダル --}}
@include('posts.components.modals.delete-modal', ['post' => $post])
{{-- 投稿コメントモーダル --}}
@include('posts.components.modals.comment-modal', ['post' => $post])
