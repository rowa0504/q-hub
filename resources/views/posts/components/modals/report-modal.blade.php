<!-- Reportモーダル -->
<div class="modal fade" id="reportModal-{{ $post->id }}" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="#" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Report Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <textarea name="reason" class="form-control" placeholder="Reason for report..." required></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Submit Report</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
