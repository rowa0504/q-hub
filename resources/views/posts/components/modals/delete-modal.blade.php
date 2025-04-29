{{-- デリートモーダル --}}
<div class="modal fade" id="deleteModal-{{ $post->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          You want to delete this post?
        </div>
        <div class="modal-footer">
            <form action="{{ route('posts.delete', $post->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
          </form>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
