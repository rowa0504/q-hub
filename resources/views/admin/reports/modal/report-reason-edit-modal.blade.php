<div class="modal fade" id="edit-reportReason-{{ $reportReason->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Report Reason
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.reportReasons.update', $reportReason->id) }}" method="post">
                    @csrf
                    @method('patch')
                        <input type="text" name="reportReason" id="reportReason" value="{{ old('reportReason',$reportReason->name) }}" placeholder="仕事内容を入力してください" class="form-control">
                        @error('reportReason')
                        <p class="text-danger small">{{ $message }}</p>
                        @enderror
            </div>
            <div class="modal-footer border-0">

                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
