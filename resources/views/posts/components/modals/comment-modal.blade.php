<!-- コメントモーダル -->
<div class="modal fade" id="commentsModal-{{ $post->id }}" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">

        <!-- モーダルヘッダー -->
        <div class="modal-header">
          <h5 class="modal-title" id="commentsModalLabel">Comments</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- モーダルボディ -->
        <div class="modal-body">

          <!-- コメント追加フォーム -->
          <form action="{{ route('comment.store', $post->id) }}" method="post" class="mb-3">
              @csrf
              <div class="input-group">
                  <textarea name="comment_body{{ $post->id }}" rows="2" class="form-control" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
                  <button class="btn btn-primary" type="submit">Post</button>
              </div>
              @error('comment_body' . $post->id)
              <div class="text-danger small">{{ $message }}</div>
              @enderror
          </form>

          <!-- コメントリスト -->
          @if ($post->comments->isNotEmpty())
              <div class="list-group">
                  @foreach ($post->comments as $comment)
                      <div class="list-group-item">
                          <strong>{{ $comment->user->name }}</strong>
                          <p class="mb-1">{{ $comment->body }}</p>
                          <small class="text-muted">{{ $comment->created_at->format('M d, Y') }}</small>

                          {{-- コメント所有者なら削除ボタン --}}
                          @if (Auth::id() === $comment->user_id)
                              <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-link btn-sm text-danger p-0">Delete</button>
                              </form>
                          @endif
                      </div>
                  @endforeach
              </div>
          @else
              <p class="text-center text-muted">No comments yet.</p>
          @endif
        </div>

      </div>
    </div>
  </div>
