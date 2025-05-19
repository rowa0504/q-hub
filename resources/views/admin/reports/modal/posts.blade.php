<div class="modal fade" id="postDetailModal-{{ $report->id }}" tabindex="-1"
    aria-labelledby="postDetailModalLabel-{{ $report->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="postDetailModalLabel-{{ $report->id }}">Reported Post Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                {{-- 投稿カード --}}
                @include('posts.components.post-card', [
                    'post' => $report->reportable,
                    'all_report_reasons' => $all_report_reasons ?? [],
                    'all_user' => collect(), // 空のコレクションでエラー回避
                ])
            </div>

            @if ($report->reportable instanceof App\Models\Post)
                <div class="modal-footer bg-white d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Post ID: {{ $report->reportable->id }}</small>
                    </div>
                    <div>
                        <!-- モーダル下部の footer 内 -->
                        @if ($report->reportable instanceof App\Models\Post)
                            <div class="modal-footer bg-white d-flex justify-content-between">
                                <div>
                                    <small class="text-muted">Post ID: {{ $report->reportable->id }}</small>
                                </div>
                                <div>
                                    @if ($report->reportable->deleted_at)
                                        <form action="{{ route('admin.posts.activate', $report->reportable->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-rotate-left"></i> Restore
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.posts.deactivate', $report->reportable->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
