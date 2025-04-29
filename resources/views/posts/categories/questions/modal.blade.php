<!-- Answer Modal -->
<div class="modal fade" id="answerModal-{{ $post->id }}" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        {{-- モーダルヘッダー --}}
        <div class="modal-header">
          <h5 class="modal-title" id="answerModalLabel">Answer to: {{ $post->title }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        {{-- モーダルボディ --}}
        <div class="modal-body">
          {{-- 回答フォーム --}}
          <form method="POST" action="#">
            @csrf
            <div class="mb-3">
              <textarea class="form-control" name="answer" rows="3" placeholder="Add a comment..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

          <hr>

          {{-- 回答一覧（仮） --}}
          <div class="mt-3">
            <h6>Answers</h6>
            <ul class="list-group">
              <li class="list-group-item">This is an example answer 1.</li>
              <li class="list-group-item">This is an example answer 2.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
