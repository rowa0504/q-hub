<!-- Edit Modal -->
<div class="modal fade" id="editModal-{{ $post->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="modal-header">
          <h5 class="modal-title">Edit Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- 投稿本文 -->
          <div class="mb-3">
            <label for="description-{{ $post->id }}" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description-{{ $post->id }}" rows="3">{{ $post->description }}</textarea>
          </div>

          <!-- 画像アップロード（任意） -->
          <div class="mb-3">
            <label for="image-{{ $post->id }}" class="form-label">Change Image (optional)</label>
            <input type="file" name="image" class="form-control" id="image-{{ $post->id }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
