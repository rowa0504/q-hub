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
            <small class="text-muted d-flex align-items-center gap-1">
                <i class="fa-solid fa-tag"></i>{{ $post->category->name }}
                @if ($post->category_id == 1)
                    <button class="dropdown-item text-warning btn-edit" data-bs-toggle="modal"
                        data-bs-target="#calendar">
                        <i class="fa-solid fa-calendar-days text-info calendar-icon mx-1"></i>
                    </button>
                @endif
            </small>
        </div>

        <div class="ms-auto">
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
        </div>
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
                @php
                    $isLiked = $post->isLiked();
                @endphp

                <div x-data="likeComponent({{ $post->id }}, {{ $post->likes->count() }}, {{ $isLiked ? 'true' : 'false' }})" class="d-flex align-items-center gap-2">
                    <button type="button" class="btn d-flex align-items-center text-muted" @click="toggleLike">
                        <i :class="liked ? 'fas fa-heart text-danger me-1' : 'far fa-heart me-1'"></i>
                        <span x-text="likesCount" class="text-muted"></span>
                    </button>
                </div>
            </div>

            {{-- コメント or アンサー --}}
            <div class="me-3">
                @if ($post->category_id == 6)
                    <button class="btn p-0 text-muted d-flex align-items-center"
                        onclick="toggleAnswer({{ $post->id }})">
                        <i class="fa-solid fa-reply me-1"></i>{{ $post->answers->count() }}
                    </button>
                @else
                    <button class="btn p-0 text-muted d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#commentsModal-{{ $post->id }}">
                        <i class="fa-regular fa-comment me-1"></i>{{ $post->comments->count() }}
                    </button>
                @endif
            </div>
        </div>


        {{-- カテゴリ別情報 --}}
        @switch($post->category_id)
            @case(1)
                @if (
                    $post->startdatetime->lt(\Carbon\Carbon::today()) &&
                        (!$post->enddatetime || $post->enddatetime->lt(\Carbon\Carbon::today())))
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
                                    {{ $post->startdatetime ? \Carbon\Carbon::parse($post->startdatetime)->format('M d, Y') : 'TBD' }}
                                </p>
                                <p class="mb-1 text-muted small">
                                    End Date:
                                    {{ $post->enddatetime ? \Carbon\Carbon::parse($post->enddatetime)->format('M d, Y') : 'TBD' }}
                                </p>

                                {{-- 参加者数と参加ボタン --}}
                                <div class="d-flex align-items-center gap-3 my-2">
                                    {{-- 参加ボタン --}}
                                    <i class="fa-regular fa-hand fa-lg"></i>

                                    {{-- 現在の参加者数 --}}
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold fs-5 text-dark">{{ $post->participations->count() }}</span>
                                        <span class="mx-2 text-muted">/</span>
                                        <span class="text-muted small">Max: {{ $post->max ?? 'TBD' }}</span>
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
                            @php
                                $isParticipated = $post->isParticipated();
                            @endphp

                            <div x-data="participantComponent({{ $post->id }}, {{ $post->participations->count() }}, {{ $isParticipated ? 'true' : 'false' }}, {{ $post->max ?? 'null' }})" class="d-flex align-items-center gap-2">
                                <button type="button" class="btn d-flex align-items-center"
                                    :class="{
                                        'text-muted': !participated && !isFull,
                                        'text-info': participated,
                                        'text-danger': !participated && isFull
                                    }"
                                    :disabled="isFull && !participated" @click="toggleParticipation">

                                    <i
                                        :class="participated ? 'fa-solid fa-hand me-1' : isFull ? 'fa-solid fa-ban me-1' :
                                            'fa-solid fa-hand text-secondary me-1'"></i>

                                    <span x-text="isFull && !participated ? 'Full' : participantsCount" class="fw-bold"></span>
                                </button>

                                {{-- 現在の参加者数 --}}
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-link text-decoration-none p-0 m-0" data-bs-toggle="modal"
                                        data-bs-target="#participant-user-{{ $post->id }}">
                                        <i class="fa-solid fa-users text-muted me-1"></i>
                                        <span x-text="participantsCount" class="text-muted small"></span>
                                    </button>
                                    <span class="mx-2 text-muted small">/</span>
                                    <span class="text-muted small">Max: {{ $post->max ?? 'TBD' }}</span>
                                </div>
                                {{-- 参加者モーダル --}}
                                @include('posts.components.modals.participation-modal')
                            </div>
                        </div>
                    </div>
                @endif
            @break

            @case(2)
                <div class="mt-2 fw-bold">
                    <p>
                        <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}"
                            target="_blank">
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $post->location ?? 'TBD' }}
                        </a>
                    </p>
                </div>
            @break

            @case(3)
                {{-- RECOMMENDED バッジ --}}
                @if ($post->is_recommended)
                    <div class="mb-2">
                        <span class="badge bg-warning text-dark">
                            <i class="fa-solid fa-star me-1"></i>
                            RECOMMENDED: 「{{ $post->matched_keyword }}」！
                        </span>
                    </div>
                @endif
                {{-- チャット開始リンク --}}
                @php
                    $users = $post->chatRoom ? $post->chatRoom->users : collect();

                    // 投稿者と管理者以外のユーザーだけカウント
                    $currentParticipants = $users
                        ->filter(fn($user) => $user->role_id !== 1 && $user->id !== $post->user_id)
                        ->count();

                    $max = $post->max ?? 0;

                    $user = Auth::user();
                    $isAdmin = $user->role_id === 1;
                    $isAuthor = $user->id === $post->user_id;
                    $isJoined = $users->contains('id', $user->id);

                    // 満員判定（ただし管理者・投稿者は制限対象外）
                    $isFull = $max > 0 && $currentParticipants >= $max;
                @endphp

                <div x-data="{
                    isFull: {{ $isFull ? 'true' : 'false' }},
                    joined: {{ $isJoined ? 'true' : 'false' }},
                    isAdmin: {{ $isAdmin ? 'true' : 'false' }},
                    isAuthor: {{ $isAuthor ? 'true' : 'false' }},
                    max: {{ $max }},
                    count: {{ $currentParticipants }}
                }" class="my-2">

                    {{-- 参加者数表示 --}}
                    <h5 class="mb-1 text-muted d-flex align-items-center">
                        <i
                            :class="isFull ? 'fa-solid fa-circle-exclamation text-danger me-1' :
                                'fa-solid fa-users text-muted me-1'"></i>
                        <span x-text="`Participants (${count} / ${max})`"></span>

                        <template x-if="isFull && !joined && !isAdmin && !isAuthor">
                            <span class="ms-2 text-danger">
                                <i class="fa-solid fa-ban me-1"></i>
                                <span class="badge bg-danger">Full</span>
                            </span>
                        </template>
                    </h5>

                    {{-- ボタン部分 --}}
                    <div>
                        {{-- 参加不可：満員かつ未参加、管理者でも投稿者でもない --}}
                        <template x-if="isFull && !joined && !isAdmin && !isAuthor">
                            <button class="btn btn-sm btn-secondary d-flex align-items-center" disabled>
                                <i class="fa-solid fa-ban me-1"></i> Join Chat (Full)
                            </button>
                        </template>

                        {{-- 参加可能：上限未満 or 参加済み or 管理者 or 投稿者 --}}
                        <template x-if="!isFull || joined || isAdmin || isAuthor">
                            <a href="{{ route('chatRoom.start', $post->id) }}" class="btn btn-sm"
                                :class="joined ? 'btn-success' : 'btn-outline-info'">
                                <i class="fa-regular fa-comments me-1"></i>
                                <span x-text="joined ? 'Enter Chat' : 'Join Chat'"></span>
                            </a>
                        </template>
                    </div>
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
                    <p>
                        <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}"
                            target="_blank">
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $post->location ?? 'TBD' }}
                        </a>
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
        @if ($post->category_id == 6)
            @include('posts.categories.questions.modal', ['post' => $post])
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


        {{-- 参加者・非同期処理 --}}
        <script>
            function participantComponent(postId, initialCount, initialParticipated, maxParticipants) {
                return {
                    postId,
                    participantsCount: initialCount,
                    participated: initialParticipated,
                    maxParticipants: maxParticipants,

                    get isFull() {
                        return this.maxParticipants !== null && this.participantsCount >= this.maxParticipants;
                    },

                    toggleParticipation() {
                        if (this.isFull && !this.participated) {
                            // すでに満員で、かつ自分が未参加なら無視
                            alert('このイベントは満員です。');
                            return;
                        }

                        fetch(`/posts/${this.postId}/participation-toggle`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                },
                            })
                            .then(res => res.json())
                            .then(data => {
                                this.participantsCount = data.participants_count;
                                this.participated = data.status === 'participated';
                            });
                    },
                };
            }
        </script>
    </div>
</div>

{{-- モーダル --}}
@include('posts.components.edit-forms.edit-form-modal', ['post' => $post])
@include('posts.components.modals.report-modal', ['post' => $post])
@include('posts.components.modals.delete-modal', ['post' => $post])
@include('posts.components.modals.comment-modal', ['post' => $post])
