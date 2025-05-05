{{-- ▼▼ 質問カテゴリー専用：アンサー入力・一覧表示 ▼▼ --}}
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
                        <i class="fa-solid fa-circle-user fa-2x text-secondary"></i>
                    </div>
                @endif
                <textarea class="form-control" name="body" rows="2" placeholder="Add an answer..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Answer</button>
        </form>

        {{-- アンサー一覧 --}}
        <hr>
        @foreach ($post->answers as $answer)
            @if ($answer->user)
                <div class="d-flex mb-2">
                    @if ($answer->user->avatar)
                        <img src="{{ $answer->user->avatar }}" class="rounded-circle me-2" width="40" height="40" alt="{{ $answer->user->name }}">
                    @else
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2" style="width:40px;height:40px;">
                            <i class="fa-solid fa-circle-user fa-2x text-secondary"></i>
                        </div>
                    @endif
                    <div>
                        <strong>{{ $answer->user->name }}</strong>
                        <p class="mb-1">{{ $answer->body }}</p>

                        {{-- ベストアンサー表示・ボタン --}}
                        @if ($post->user_id === Auth::id())
                            @if ($post->best_answer_id === $answer->id)
                                <span class="badge bg-success">Best Answer</span>
                            @endif
                            <form method="POST" action="{{ route('answer.best', $answer->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm mt-1">Mark as Best</button>
                            </form>
                        @elseif ($post->best_answer_id === $answer->id)
                            <span class="badge bg-success">Best Answer</span>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
