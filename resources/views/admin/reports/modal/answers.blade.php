<!-- admin/reports/modal/answers.blade.php -->
<div class="modal fade" id="answerDetailModal-{{ $report->id }}" tabindex="-1"
    aria-labelledby="answerDetailModalLabel-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="answerDetailModalLabel-{{ $report->id }}">Reported Answer Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">
                            Answer by: {{ $report->reportable->user->name ?? 'Unknown' }}
                        </h6>
                        <p class="card-text">
                            {{ $report->reportable->body }}
                        </p>
                    </div>
                </div>

                <!-- 関連する投稿表示（リンク付き） -->
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
                    <small class="text-muted">Answer ID: {{ $report->reportable->id }}</small>
                </div>
                <div>
                    <form action="{{ route('admin.answers.deactivate', $report->reportable->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can me-1"></i> Delete Answer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
