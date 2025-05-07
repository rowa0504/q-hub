<div class="modal fade" id="warnModal-{{ $post->id }}" tabindex="-1" aria-labelledby="warnModalLabel-{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="warnModalLabel-{{ $post->id }}">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Send Warning to {{ $post->user->name ?? 'User' }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form action="{{ route('admin.posts.warn', $post->id) }}" method="POST">
          @csrf

          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Reported Reasons</label>
              <ul class="list-group">
                @forelse ($postReportedReasons[$post->id] ?? [] as $reason)
                    <li class="list-group-item">{{ $reason }}</li>
                @empty
                    <li class="list-group-item text-muted">No reasons reported.</li>
                @endforelse
            </ul>

            </div>

            {{-- メッセージ入力欄 --}}
            <div class="mb-3 mt-3">
              <label class="form-label fw-bold">Message</label>
              <textarea name="message" class="form-control" rows="4" required placeholder="Write a custom warning message..."></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning">
              <i class="fa-solid fa-paper-plane"></i> Send Warning
            </button>
          </div>
        </form>
      </div>
    </div>
</div>
