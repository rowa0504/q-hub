<!-- admin/reports/modal/comments.blade.php -->
<div class="modal fade" id="commentDetailModal-{{ $report->id }}" tabindex="-1"
    aria-labelledby="commentDetailModalLabel-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="commentDetailModalLabel-{{ $report->id }}">Reported Comment Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">
                            Comment by: {{ $report->reportable->user->name ?? 'Unknown' }}
                        </h6>
                        <p class="card-text">
                            {{ $report->reportable->body }}
                        </p>
                    </div>
                </div>

                <!-- 投稿タイトル表示（リンク付き） -->
                @if ($report->reportable->post && method_exists($report->reportable->post, 'getCategoryRoute'))
                    <div class="mb-3">
                        <strong>Related Post:</strong>
                        <a href="{{ $report->reportable->post->getCategoryRoute() }}"
                            class="text-decoration-none" target="_blank">
                            {{ $report->reportable->post->title }}
                        </a>
                    </div>
                @endif
            </div>


            <div class="modal-footer bg-white d-flex justify-content-between">
                <div>
                    <small class="text-muted">Comment ID: {{ $report->reportable->id }}</small>
                </div>
                <div>
                    <form action="{{ route('admin.comments.deactivate', $report->reportable->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can me-1"></i> Delete Comment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
