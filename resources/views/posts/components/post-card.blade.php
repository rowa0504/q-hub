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
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $post->id }}">
                        <i class="fa-solid fa-trash"></i> Delete</a></li>
                    <li>
                        <button class="dropdown-item text-warning btn-edit" data-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#edit-form-{{ $post->id }}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                    </li>
                @else
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $post->id }}">
                        <i class="fa-solid fa-flag"></i> Report</a></li>
                @endif
            </ul>
        </div>
    </div>

    {{-- 投稿画像 --}}
    <a href="{{ $post->getCategoryRoute() }}">
        <img src="{{ $post->image }}" class="img-fluid img-thumbnail" alt="Post Image">
    </a>

    <div class="card-body">
        {{-- いいね・コメント --}}
        <div class="d-flex align-items-center mb-2">
            {{-- いいね --}}
            <div class="me-3 d-flex align-items-center">
                @if ($post->isLiked())
                    <form action="{{ route('like.delete', $post->id) }}" method="post" class="d-flex align-items-center">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm p-0 border-0 bg-transparent d-flex align-items-center">
                            <i class="fa-solid fa-heart text-danger"></i>
                        </button>
                        <span class="ms-1">{{ $post->likes->count() }}</span>
                    </form>
                @else
                    <form action="{{ route('like.store', $post->id) }}" method="post" class="d-flex align-items-center">
                        @csrf
                        <button class="btn btn-sm p-0 border-0 bg-transparent d-flex align-items-center">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <span class="ms-1">{{ $post->likes->count() }}</span>
                    </form>
                @endif
            </div>

            {{-- コメント or アンサー --}}
            <div class="me-3">
                @if ($post->category_id == 6)
                    <span onclick="toggleAnswer({{ $post->id }})" style="cursor:pointer;">
                        <i class="fa-solid fa-reply"></i>
                    </span>
                @else
                    <span data-bs-toggle="modal" data-bs-target="#commentsModal-{{ $post->id }}" style="cursor:pointer;">
                        <i class="fa-regular fa-comment"></i>
                    </span>
                @endif
                <span>{{ $post->comments->count() }}</span>
            </div>
        </div>

        {{-- カテゴリ別情報 --}}
        @switch($post->category_id)
            @case(1)
                <div class="mt-2 fw-bold">
                    <p>Event: {{ $post->title ?? 'TBD' }}</p>
                    <p>Start: {{ optional($post->startdatetime)->format('M d, Y H:i') ?? 'TBD' }}</p>
                    <p>End: {{ optional($post->enddatetime)->format('M d, Y H:i') ?? 'TBD' }}</p>
                    <p>Max participants: {{ $post->max ?? 'TBD' }}</p>
                </div>
                @break
            @case(2)
                <div class="mt-2 fw-bold">
                    <p>Title: {{ $post->title ?? 'TBD' }}</p>
                    <p>Location: {{ $post->location ?? 'TBD' }}</p>
                </div>
                @break
            @case(3)
                <div class="mt-2 fw-bold">
                    <p>Item name: {{ $post->title ?? 'TBD' }}</p>
                    <p>Max participants: {{ $post->max ?? 'TBD' }}</p>
                </div>
                @break
            @case(4)
                <div class="mt-2 fw-bold">
                    <p>Title: {{ $post->title ?? 'TBD' }}</p>
                    <p>Location: {{ $post->location ?? 'TBD' }}</p>
                </div>
                @break
            @case(5)
                <div class="mt-2 fw-bold">
                    <p>Fee: {{ $post->fee ?? 'TBD' }}₱</p>
                    <p>Departure: {{ $post->departure ?? 'TBD' }}</p>
                    <p>Destination: {{ $post->destination ?? 'TBD' }}</p>
                </div>
                @break
            @case(6)
                <div class="mt-2 fw-bold">
                    <p>Question: {{ $post->title ?? 'TBD' }}</p>
                </div>
                @break
        @endswitch

        {{-- 本文 --}}
        <p class="fw-bold">{{ $post->description }}</p>
        <p class="text-uppercase text-muted small mb-0">{{ $post->created_at->format('M d, Y') }}</p>

        {{-- ▼▼ 質問カテゴリー専用：アンサー入力・一覧表示 ▼▼ --}}
        @if ($post->category_id == 6)
            <div class="px-3 pb-3">
                <button class="btn btn-sm btn-outline-secondary mt-2" onclick="toggleAnswer({{ $post->id }})">
                    <i class="fa-solid fa-reply"></i> Show Answers
                </button>

                <div id="answer-section-{{ $post->id }}" class="mt-3"
                     style="{{ session('open_answer_post_id') == $post->id ? 'display: block;' : 'display: none;' }}">

                    {{-- アンサー投稿フォーム --}}
                    <form method="POST" action="{{ route('answer.store') }}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="d-flex mb-3">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" class="rounded-circle me-2" width="40" height="40" alt="avatar">
                            @else
                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2" style="width:40px;height:40px;">
                                    <i class="fa-solid fa-circle-user text-secondary"></i>
                                </div>
                            @endif
                            <textarea class="form-control" name="body" rows="2" placeholder="Add an answer..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Answer</button>
                    </form>

                    {{-- アンサー一覧 --}}
                    <hr>
                    @foreach ($post->answers as $answer)
                        <div class="d-flex mb-2">
                            @if ($answer->user->avatar)
                                <img src="{{ $answer->user->avatar }}" class="rounded-circle me-2" width="40" height="40" alt="{{ $answer->user->name }}">
                            @else
                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2" style="width:40px;height:40px;">
                                    <i class="fa-solid fa-circle-user text-secondary"></i>
                                </div>
                            @endif
                            <div>
                                <strong>{{ $answer->user->name }}</strong>
                                <p class="mb-1">{{ $answer->body }}</p>

                                {{-- ベストアンサー表示・ボタン --}}
                                @if ($post->user_id === Auth::id())
                                    {{-- 投稿者本人 --}}
                                    @if ($post->best_answer_id === $answer->id)
                                        <span class="badge bg-success">Best Answer</span>
                                    @endif
                                    <form method="POST" action="{{ route('answer.best', $answer->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm mt-1">Mark as Best</button>
                                    </form>
                                @elseif ($post->best_answer_id === $answer->id)
                                    {{-- 他人から見たときも表示 --}}
                                    <span class="badge bg-success">Best Answer</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- スクロール保持 --}}
        <script>
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                });
            });

            window.addEventListener('load', () => {
                const position = sessionStorage.getItem('scrollPosition');
                if (position) {
                    window.scrollTo(0, parseInt(position));
                    sessionStorage.removeItem('scrollPosition');
                }
            });

            function toggleAnswer(postId) {
                const section = document.getElementById(`answer-section-${postId}`);
                if (section.style.display === 'none' || section.style.display === '') {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            }
        </script>

    </div>
</div>

{{-- モーダル --}}
@include('posts.components.modals.edit-modal', ['post' => $post])
@include('posts.components.modals.report-modal', ['post' => $post])
@include('posts.components.modals.delete-modal', ['post' => $post])
@include('posts.components.modals.comment-modal', ['post' => $post])
