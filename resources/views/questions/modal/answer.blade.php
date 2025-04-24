<!-- モーダル: Submit an Answer -->
<div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="#" method="POST" enctype="multipart/form-data"> {{-- ファイル送信に必要 --}}
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="answerModalLabel">Submit Your Answer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="answer-body" class="form-label">Your Answer</label>
              <textarea class="form-control" id="answer-body" name="body" rows="4" placeholder="Type your answer here..."></textarea>
            </div>
            <div class="mb-3">
              <label for="answer-file" class="form-label">Attach File</label>
              <input type="file" class="form-control" id="answer-file" name="file">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
