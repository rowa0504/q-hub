<div class="modal fade" id="warnMessage-{{ $report->id }}" tabindex="-1" aria-labelledby="warnMessageLabel-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="warnModalLabel-{{ $report->id }}">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Sent Message
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form action="{{ route('admin.updateReportMessage', $report->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="modal-body">
                <div class="mb-3 mt-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="message" class="form-control" rows="4" required placeholder="Write a custom warning message...">{{ old('message', $report->message) }}</textarea>
                </div>
                @error('message')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning">
                <i class="fa-solid fa-paper-plane"></i> Edit Message
                </button>
        </form>
            <form action="{{ route('admin.deleteReportMessage', $report->id) }}" method="post">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </div>
      </div>
    </div>
</div>
