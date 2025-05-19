<div class="modal fade" id="delete-reportReason-{{ $reportReason->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> Delete Report Reason
                </h3>
            </div>
            <div class="modal-body">
                <p class="text-start">Do you really want to delete Report Reason：<span class="fw-bold">{{ $reportReason->name }}</span>？</p>
                
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.reportReasons.delete', $reportReason->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
