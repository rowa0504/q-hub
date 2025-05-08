{{-- ダミーデータで警告モーダルを表示 --}}
<div class="modal fade show" id="warningModal" style="display:block;" tabindex="-1" aria-labelledby="warningModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="warningModalLabel">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Warning Received
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="document.getElementById('warningModal').style.display='none'"></button>
            </div>
            <div class="modal-body">
                <p>This is a test warning message from admin.</p>
                <p class="text-muted small">Sent at: {{ now()->format('Y-m-d H:i') }}</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="document.getElementById('warningModal').style.display='none'">Close</button>
            </div>
        </div>
    </div>
</div>
