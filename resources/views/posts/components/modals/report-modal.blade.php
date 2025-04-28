<!-- 例: 投稿が表示されている部分 -->
@foreach($posts as $post)
    <!-- 投稿情報の表示 -->
    <div class="post">
        <h5>{{ $post->title }}</h5>
        <p>{{ $post->body }}</p>

        <!-- 通報ボタン -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $post->id }}">
            🚨 通報する
        </button>

        {{-- Report モーダル --}}
        <div class="modal fade" id="reportModal-{{ $post->id }}" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger" id="reportModalLabel">Report this post?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('posts.report', $post->id) }}" method="POST">
                        @csrf
                        <div class="modal-body text-start">
                            <div class="form-check mb-2">
                                <input class="form-check-input me-3" type="checkbox" name="reasons[]" value="Hate Speech or Symbols" id="reason1">
                                <label class="form-check-label" for="reason1">Hate Speech or Symbols</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input me-3" type="checkbox" name="reasons[]" value="Nudity or Sexual Content" id="reason2">
                                <label class="form-check-label" for="reason2">Nudity or Sexual Content</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input me-3" type="checkbox" name="reasons[]" value="Violence or Dangerous" id="reason3">
                                <label class="form-check-label" for="reason3">Violence or Dangerous</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input me-3" type="checkbox" name="reasons[]" value="Scams or Fraud" id="reason4">
                                <label class="form-check-label" for="reason4">Scams or Fraud</label>
                            </div>
                        </div>

                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <span class="text-muted text-start">* You can choose multiple options</span>
                            <button type="submit" class="btn btn-danger w-100">Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
