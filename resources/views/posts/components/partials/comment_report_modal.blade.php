<div class="modal fade" id="reportCommentModal-{{ $comment->id }}" tabindex="-1"
    aria-labelledby="reportCommentModalLabel-{{ $comment->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">Report this comment?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('report.store', $comment->id) }}" method="POST">
                @csrf
                <input type="hidden" name="reportable_type" value="App\Models\Comment">

                <div class="modal-body text-start">
                    @foreach ($all_report_reasons as $report_reason)
                        <div class="form-check mb-2">
                            <input class="form-check-input me-3" type="checkbox" name="reason[]"
                                value="{{ $report_reason->id }}"
                                id="reason-{{ $report_reason->id }}-{{ $comment->id }}">
                            <label class="form-check-label"
                                for="reason-{{ $report_reason->id }}-{{ $comment->id }}">{{ $report_reason->name }}</label>
                        </div>
                    @endforeach

                    @error('reason')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-footer border-0 d-flex justify-content-center">
                    <span class="text-muted text-start">* You can choose multiple options</span>
                    <button type="submit" class="btn btn-danger w-100">Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
