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
                    <img src="{{ Auth::user()->avatar }}" class="rounded-circle me-2" width="40" height="40"
                        alt="avatar">
                @else
                    <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                        style="width:40px;height:40px;">
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
                    {{-- ユーザーアイコン --}}
                    @if ($answer->user->avatar)
                        <img src="{{ $answer->user->avatar }}" class="rounded-circle me-2" width="40" height="40"
                            alt="{{ $answer->user->name }}">
                    @else
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                            style="width:40px;height:40px;">
                            <i class="fa-solid fa-circle-user fa-2x text-secondary"></i>
                        </div>
                    @endif

                    {{-- アンサー内容 --}}
                    <div class="w-100">
                        <strong>{{ $answer->user->name }}</strong>

                        {{-- 表示用 --}}
                        <p class="mb-1" id="answer-body-{{ $answer->id }}">{{ $answer->body }}</p>

                        {{-- 編集フォーム（非表示） --}}
                        <form class="d-none" id="edit-answer-form-{{ $answer->id }}" method="POST"
                            action="{{ route('answer.update', $answer->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="input-group mb-2">
                                <input type="text" name="body" class="form-control form-control-sm"
                                    value="{{ $answer->body }}" required>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                <button type="button" class="btn btn-sm btn-secondary"
                                    onclick="cancelAnswerEdit({{ $answer->id }})">Cancel</button>
                            </div>
                        </form>

                        {{-- ベストアンサー表示・ボタン --}}
                        @if ($post->user_id === Auth::id())
                            @if ($post->best_answer_id === $answer->id)
                                <span class="badge bg-success">Best Answer</span>
                                <form method="POST" action="{{ route('answer.best', $answer->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm mt-1">
                                        Remove Best
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('answer.best', $answer->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm mt-1">
                                        Mark as Best
                                    </button>
                                </form>
                            @endif
                        @elseif ($post->best_answer_id === $answer->id)
                            <span class="badge bg-success">Best Answer</span>
                        @endif

                        {{-- 編集・削除・レポートボタン --}}
                        <div class="dropdown mt-1">
                            <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu">
                                @if (Auth::id() === $answer->user_id)
                                    <li>
                                        <a href="#" class="dropdown-item text-warning"
                                            onclick="event.preventDefault(); editAnswer({{ $answer->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('answer.destroy', $answer->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#reportAnswerModal-{{ $answer->id }}">
                                            <i class="fa-solid fa-flag me-1"></i> Report
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- ▼▼ 各アンサーに対応するReportモーダル（仮） ▼▼ --}}
@foreach ($post->answers as $answer)
    @if ($answer->user)
        {{-- モーダル本体 --}}
        <div class="modal fade" id="reportAnswerModal-{{ $answer->id }}" tabindex="-1" aria-labelledby="reportModalLabel-{{ $answer->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger" id="reportModalLabel">Report this post?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('report.store', $answer->id) }}" method="POST">
                        @csrf

                        <input type="text" hidden name="reportable_type" value="App\Models\Answer">
                        <div class="modal-body text-start">
                            @foreach($all_report_reasons as $report_reason )
                            <div class="form-check mb-2">
                                <input class="form-check-input me-3" type="checkbox" name="reason[]" value="{{ $report_reason->id }}" id="{{ $report_reason->name }}">
                                <label class="form-check-label" for="{{ $report_reason->name }}">{{ $report_reason->name }}</label>
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
    @endif
@endforeach

<script>
    function editAnswer(id) {
        document.getElementById(`answer-body-${id}`).classList.add('d-none');
        document.getElementById(`edit-answer-form-${id}`).classList.remove('d-none');
    }

    function cancelAnswerEdit(id) {
        document.getElementById(`answer-body-${id}`).classList.remove('d-none');
        document.getElementById(`edit-answer-form-${id}`).classList.add('d-none');
    }
</script>

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
