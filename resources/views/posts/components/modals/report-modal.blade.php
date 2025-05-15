{{-- Report モーダル --}}
<div class="modal fade" id="reportPostModal-{{ $post->id }}" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger" id="reportModalLabel">Report this post?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('report.store', $post->id) }}" method="POST">
                @csrf
                <input type="text" hidden name="reportable_type" value="App\Models\Post">
                <div class="modal-body text-start">
                    @foreach($all_report_reasons as $report_reason )
                    <div class="form-check mb-2">
                        <input class="form-check-input me-3" type="checkbox" name="reason[]" value="{{ $report_reason->id }}" id="{{ $report_reason->name }}">
                        <label class="form-check-label" for="{{ $report_reason->name }}">{{ $report_reason->name }}</label>
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

@if (session('open_modal'))
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const modalId = '{{ session('open_modal') }}';
            const targetModal = document.getElementById(modalId);
            if (targetModal) {
                const bsModal = new bootstrap.Modal(targetModal);
                bsModal.show();
            }
        });
    </script>
@endif
