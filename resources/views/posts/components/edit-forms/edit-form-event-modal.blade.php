<!--  postFormModal を追加 -->
<div class="modal fade" id="edit-form-4" tabindex="-1" aria-labelledby="otherPostModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
        <div class="modal-header">
            <h5 class="modal-title" id="otherPostModalLabel">Edit Event Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editEventForm" action="#" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="modal-body">
                <!-- Image preview -->
                <div class="mb-3 text-center">
                    <img id="imagePreview4" src="https://via.placeholder.com/300x200" alt="Image Preview"
                        class="img-fluid rounded">
                </div>

                <!-- File input -->
                <div class="mb-3">
                    <input class="form-control" type="file" name="image" id="event-imageInput" accept="image/*">
                    @error('image')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Max input --}}
                <div class="mb-3">
                    <input type="number" name="max" id="event-max" class="form-control" placeholder="max">
                    @error('max')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Startdate input --}}
                <div class="mb-3">
                    <input type="date" class="form-control" id="event-startdate" name="startdate">
                    @error('startdate')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Enddate input --}}
                <div class="mb-3">
                    <input type="date" class="form-control" id="event-enddate" name="enddate">
                    @error('enddate')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title input -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" id="event-title" placeholder="Enter your post title...">
                    @error('title')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description input -->
                <div class="mb-3">
                    <textarea class="form-control" name="description" id="event-description" placeholder="Enter your post description..." rows="3"></textarea>
                    @error('description')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning text-white">Edit</button>

                <input type="hidden" name="category_id" value="4">
            </div>
        </form>
    </div>
</div>
</div>

<script>
document.getElementById('imageInput4').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('imagePreview4').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

$('.btn-edit').on('click', function () {
    const postId = $(this).data('id');

    $.get(`/posts/${postId}/edit`, function (data) {
        // フォームへのデータの流し込み
        $('#event-title').val(data.title || '');
        $('#event-description').val(data.description || '');
        $('#event-startdate').val(data.startdate || '');
        $('#event-enddate').val(data.enddate || '');
        $('#event-max').val(data.max || '');

        // 画像プレビュー（存在する場合）
        if (data.image) {
            $('#imagePreview4').attr('src', data.image);
        } else {
            $('#imagePreview4').attr('src', 'https://via.placeholder.com/300x200');
        }

        // フォームのaction属性を更新
        $('#editEventForm').attr('action', `/posts/${postId}`);

        // モーダルを手動で表示（data-bs-target は外してもOK）
        $('#edit-form-4').modal('show');
    });
});

</script>
