<div class="card shadow-sm mb-4 rounded-4 overflow-hidden">
    {{-- 投稿ヘッダー --}}
    <div class="d-flex align-items-center border-bottom px-3 py-2 bg-light">
        <a href="{{ route('profile.index', $post->user->id ?? '#') }}" class="text-decoration-none">
            @if ($post->user && $post->user->avatar)
                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="rounded-circle avatar-md">
            @else
                <i class="fa-solid fa-circle-user text-secondary avatar-md"></i>
            @endif
        </a>
        <div class="ms-2">
            <strong class="d-block">{{ $post->user->name ?? 'UNKNOWN user' }}</strong>
            <small class="text-muted">
                <i class="fa-solid fa-tag me-1"></i>{{ $post->category->name }}
            </small>
        </div>

        {{-- <div class="ms-auto">
            <i class="fas fa-ellipsis-h text-muted" style="cursor:pointer;" data-bs-toggle="dropdown"></i>

            <ul class="dropdown-menu dropdown-menu-end">
                @if (Auth::id() === $post->user_id)
                    <li>
                        <button class="dropdown-item text-warning btn-edit" data-id="{{ $post->id }}"
                            data-bs-toggle="modal" data-bs-target="#edit-form-{{ $post->id }}">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                        </button>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-{{ $post->id }}">
                            <i class="fa-solid fa-trash me-1"></i> Delete
                        </a>
                    </li>
                @else
                    <li>
                        <a class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#reportPostModal-{{ $post->id }}">
                            <i class="fa-solid fa-flag me-1"></i> Report
                        </a>
                    </li>
                @endif
            </ul>
        </div> --}}
    </div>

    {{-- 説明文（上部） --}}
    <div class="card-body pb-0">
        <div x-data="{ expanded: false }">
            <p class="fs-5 fw-bold mb-2">
                <span x-text="expanded ? @js($post->description) : @js(Str::limit($post->description, 100))"></span>
            </p>

            @if (strlen($post->description) > 100)
                <button class="btn btn-link p-0" @click="expanded = !expanded">
                    <span x-text="expanded ? 'Read less' : 'Read more'"></span>
                </button>
            @endif
        </div>
    </div>

    @if ($post->images->isNotEmpty())
        <div class="card-image-scroll-wrapper">
            <a href="{{ $post->getCategoryRoute() }}" class="card-image-scroll-container" id="imageScrollContainer">
                @foreach ($post->images as $image)
                    <img src="{{ $image->path }}" alt="Post Image" class="card-scroll-image">
                @endforeach
            </a>
            <div class="card-scroll-indicators" id="scrollIndicators">
                @foreach ($post->images as $index => $image)
                    <span class="card-indicator-dot {{ $index === 0 ? 'active' : '' }}"></span>
                @endforeach
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeImageScrollers(); // 初回読み込み用
        });

        function initializeImageScrollers() {
            document.querySelectorAll('.card-image-scroll-wrapper:not([data-initialized])').forEach((wrapper, index) => {
                const container = wrapper.querySelector('.card-image-scroll-container');
                const dots = wrapper.querySelectorAll('.card-indicator-dot');

                function updateActiveDot() {
                    const scrollLeft = container.scrollLeft;
                    const containerWidth = container.clientWidth;
                    const activeIndex = Math.round(scrollLeft / containerWidth);

                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === activeIndex);
                    });
                }

                container.addEventListener('scroll', updateActiveDot);

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        container.scrollTo({
                            left: container.clientWidth * i,
                            behavior: 'smooth'
                        });
                    });
                });

                wrapper.setAttribute('data-initialized', 'true');
            });
        }
    </script>



    <div class="card-body">
        {{-- いいね・コメント --}}
        <div class="d-flex align-items-center mb-3">
            {{-- いいね --}}
            <div class="me-3">
                {{-- @php
                    $isLiked = $post->isLiked();
                @endphp --}}

                {{-- <div x-data="likeComponent({{ $post->id }}, {{ $post->likes->count() }}, {{ $isLiked ? 'true' : 'false' }})" class="d-flex align-items-center gap-2">
                    <button type="button" class="btn d-flex align-items-center text-muted" @click="toggleLike"> --}}
                        <i class="fas fa-heart text-danger me-1"></i>
                        <span x-text="likesCount" class="text-muted">0</span>
                    {{-- </button>
                </div> --}}
            </div>

            {{-- コメント or アンサー --}}
            <div class="me-3">
                @if ($post->category_id == 6)
                    {{-- <button class="btn p-0 text-muted d-flex align-items-center"
                        onclick="toggleAnswer({{ $post->id }})"> --}}
                        <i class="fa-solid fa-reply me-1"></i>0
                    {{-- </button> --}}
                @else
                    {{-- <button class="btn p-0 text-muted d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#commentsModal-{{ $post->id }}"> --}}
                        <i class="fa-regular fa-comment me-1"></i>0
                    {{-- </button> --}}
                @endif
            </div>
        </div>


        {{-- カテゴリ別情報 --}}
        @switch($post->category_id)
            @case(1)
                @if ($post->startdatetime->isPast() && (!$post->enddatetime || $post->enddatetime->isPast()))
                    <div class="bg-light text-muted position-relative p-4 rounded shadow-sm">
                        {{-- 終了メッセージ --}}
                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <h5 class="fw-bold mb-0">This event has ended</h5>
                        </div>

                        {{-- 内容を薄く表示するエリア（必要に応じて囲んでください） --}}
                        <div class="opacity-50">
                            <div class="mt-2 fw-bold">
                                <p class="mb-1 text-muted small">
                                    Start Date:
                                    {{ $post->startdatetime ? \Carbon\Carbon::parse($post->startdatetime)->format('M d, Y H:i') : 'TBD' }}
                                </p>
                                <p class="mb-1 text-muted small">
                                    End Date:
                                    {{ $post->enddatetime ? \Carbon\Carbon::parse($post->enddatetime)->format('M d, Y H:i') : 'TBD' }}
                                </p>

                                {{-- 参加者数と参加ボタン --}}
                                <div class="d-flex align-items-center gap-3 my-2">
                                    {{-- 参加ボタン --}}
                                    <i class="fa-regular fa-hand fa-lg"></i>

                                    {{-- 現在の参加者数 --}}
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold fs-5 text-dark">0</span>
                                        <span class="mx-2 text-muted">/</span>
                                        <span class="text-muted small">Max: 20</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-2 fw-bold">
                        <p class="mb-1 text-muted small">
                            Start Date:
                            {{ $post->startdatetime ? \Carbon\Carbon::parse($post->startdatetime)->format('M d, Y') : 'TBD' }}
                        </p>
                        <p class="mb-1 text-muted small">
                            End Date:
                            {{ $post->enddatetime ? \Carbon\Carbon::parse($post->enddatetime)->format('M d, Y') : 'TBD' }}
                        </p>

                        {{-- 参加者数と参加ボタン --}}
                        <div class="d-flex align-items-center gap-3 my-2">
                            {{-- 参加ボタン --}}
                            {{-- @if ($post->participations->count() >= $post->max)
                                @if ($post->isParticipanted())
                                    <form action="{{ route('participation.delete', $post->id) }}" method="post"
                                        class="d-flex align-items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm shadow-none p-0"> --}}
                                            <i class="fa-regular fa-hand fa-lg"></i>
                                        {{-- </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm shadow-none p-0" disabled>
                                        <i class="fa-solid fa-hand text-danger fa-lg"></i>
                                    </button>
                                @endif
                            @else
                                @if ($post->isParticipanted())
                                    <form action="{{ route('participation.delete', $post->id) }}" method="post"
                                        class="d-flex align-items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm shadow-none p-0">
                                            <i class="fa-solid fa-hand text-primary fa-lg"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('participation.store', $post->id) }}" method="post"
                                        class="d-flex align-items-center">
                                        @csrf
                                        <button class="btn btn-sm shadow-none p-0">
                                            <i class="fa-regular fa-hand fa-lg"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif --}}

                            {{-- 現在の参加者数 --}}
                            <div class="d-flex align-items-center">
                                {{-- <button class="btn btn-link text-decoration-none p-0 m-0" data-bs-toggle="modal"
                                    data-bs-target="#participant-user-{{ $post->id }}"> --}}
                                    <i class="fa-solid fa-users text-muted me-1"></i>
                                    <span class="fw-bold fs-5 text-dark">0</span>
                                {{-- </button> --}}
                                <span class="mx-2 text-muted">/</span>
                                <span class="text-muted small">Max: 20</span>
                            </div>
                        </div>
                        {{-- @include('posts.components.modals.participation-modal') --}}
                    </div>
                @endif
            @break

            @case(2)
                <div class="mt-2 fw-bold">
                    <p class="text-primary text-decoration-underline">
                        {{-- <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}"
                            target="_blank"> --}}
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $post->location ?? 'TBD' }}
                        {{-- </a> --}}
                    </p>
                </div>
            @break

            @case(3)
                {{-- RECOMMENDED バッジ --}}
                {{-- @if ($post->is_recommended)
                    <div class="mb-2">
                        <span class="badge bg-warning text-dark">
                            <i class="fa-solid fa-star me-1"></i>
                            RECOMMENDED: 「{{ $post->matched_keyword }}」！
                        </span>
                    </div>
                @endif --}}

                {{-- 参加者数 --}}
                {{-- @if ($post->chatRoom) --}}
                    <h5 class="mb-2">
                        Participants (0 / 10)
                    </h5>
                {{-- @else
                    <h5 class="mb-2">
                        Participants (0 / {{ $post->max }})
                    </h5>
                @endif --}}


                {{-- チャット開始リンク --}}
                @php
                    $joined = $post->chatRoom && $post->chatRoom->users->contains(Auth::id());
                @endphp

                <div class="mb-2">
                    <a href="{{ route('chatRoom.start', $post->id) }}"
                        class="btn btn-sm {{ $joined ? 'btn-success' : 'btn-outline-primary' }}">
                        <i class="fa-brands fa-rocketchat me-1"></i>
                        {{ $joined ? 'Enter Chat' : 'Join Chat' }}
                    </a>
                </div>

                <p class="mb-1 text-muted small">
                    Start Date:
                    {{ $post->startdatetime ? \Carbon\Carbon::parse($post->startdatetime)->format('M d, Y') : 'TBD' }}
                </p>
                <p class="mb-1 text-muted small">
                    End Date:
                    {{ $post->enddatetime ? \Carbon\Carbon::parse($post->enddatetime)->format('M d, Y') : 'TBD' }}
                </p>


                {{-- エラーメッセージ --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            @break

            @case(4)
                <div class="mt-2 fw-bold">
                    <p class="text-primary text-decoration-underline">
                        {{-- <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}"
                            target="_blank"> --}}
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $post->location ?? 'TBD' }}
                        {{-- </a> --}}
                    </p>
                </div>
            @break

            @case(5)
                <div class="mt-2 fw-bold">
                    <p class="mb-1">
                        Transportation:
                        @if ($post->transCategory)
                            @php
                                $name = $post->transCategory->name;
                            @endphp
                            @if ($name === 'Bike')
                                <i class="fas fa-motorcycle"></i>
                                {{ $name }}
                            @elseif ($name === 'Taxi')
                                <i class="fas fa-car"></i>
                                {{ $name }}
                            @elseif ($name === 'Jeepney')
                                <i class="fas fa-bus"></i>
                                {{ $name }}
                            @else
                                <i class="fas fa-question-circle"></i> {{-- 未定義カテゴリ用 --}}
                            @endif
                        @else
                            TBD <i class="fas fa-question-circle"></i>
                        @endif
                    </p>
                    <p class="mb-1 text-muted small">Departure: {{ $post->departure ?? 'TBD' }}</p>
                    <p class="mb-1 text-muted small">Destination: {{ $post->destination ?? 'TBD' }}</p>
                    <p class="mb-1 text-muted small">Fee: {{ $post->fee ?? 'TBD' }}₱</p>
                </div>
            @break

            @case(6)
                <div class="mt-2 fw-bold">
                    <p>Question: {{ $post->title ?? 'TBD' }}</p>
                </div>
            @break

            @default
        @endswitch

        {{-- 投稿本文 --}}
        <p class="text-uppercase text-muted small mb-0">{{ $post->created_at->format('M d, Y') }}</p>

        {{-- ▼▼ 質問カテゴリー専用：アンサー入力・一覧表示 ▼▼ --}}
        {{-- @if ($post->category_id == 6)
            @include('posts.categories.questions.modal', ['post' => $post])
        @endif --}}



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

        <script>
            function likeComponent(postId, initialLikesCount, isLikedInitially) {
                return {
                    liked: isLikedInitially === true || isLikedInitially === 'true',
                    likesCount: initialLikesCount,

                    toggleLike() {
                        fetch(`/posts/${postId}/like-toggle`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'liked') {
                                    this.liked = true;
                                    this.likesCount = data.likes_count;
                                } else if (data.status === 'unliked') {
                                    this.liked = false;
                                    this.likesCount = data.likes_count;
                                } else {
                                    console.error("Unknown response", data);
                                }
                            })
                            .catch(() => alert("接続エラー"));
                    }
                }
            }
        </script>

    </div>
</div>

{{-- モーダル --}}
{{-- @include('posts.components.edit-forms.edit-form-modal', ['post' => $post])
@include('posts.components.modals.report-modal', ['post' => $post])
@include('posts.components.modals.delete-modal', ['post' => $post])
@include('posts.components.modals.comment-modal', ['post' => $post]) --}}
