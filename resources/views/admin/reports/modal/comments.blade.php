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

                <!-- 関連投稿のタイトル・説明表示 -->
                @if ($report->reportable->post && method_exists($report->reportable->post, 'getCategoryRoute'))
                    @php
                        $relatedPost = $report->reportable->post;
                    @endphp
                    <div class="mb-3">
                        <strong>Related Post:</strong><br>
                        <a href="{{ $relatedPost->getCategoryRoute() }}" class="text-decoration-none" target="_blank">
                            <i class="fa-solid fa-link me-1"></i>{{ $relatedPost->title }}
                        </a>
                        <p class="mt-1 mb-0 text-muted">
                            {{ Str::limit($relatedPost->description, 150) }}
                        </p>
                    </div>
                @endif
            </div>

            <div class="modal-footer bg-white d-flex justify-content-between">
                <div>
                    <small class="text-muted">Comment ID: {{ $report->reportable->id }}</small>
                </div>
                <div>
                    @if ($report->reportable->deleted_at)
                        <form action="{{ route('admin.comments.activate', $report->reportable->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-rotate-left"></i> Restore
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.comments.deactivate', $report->reportable->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
