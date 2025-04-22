<!--  postFormModal を追加 -->
<div class="modal fade" id="otherPostModal" tabindex="-1" aria-labelledby="otherPostModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
        <div class="modal-header">
            <h5 class="modal-title" id="otherPostModalLabel">Create Other Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
            <div class="modal-body">
                <!-- Image preview -->
                <div class="mb-3 text-center">
                    <img id="imagePreview" src="https://via.placeholder.com/300x200" alt="Image Preview"
                        class="img-fluid rounded">
                </div>

                <!-- File input -->
                <div class="mb-3">
                    <input class="form-control" type="file" id="imageInput" accept="image/*">
                </div>

                <!-- Title input -->
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Enter your post title...">
                </div>

                <!-- Description input -->
                <div class="mb-3">
                    <textarea class="form-control" placeholder="Enter your post description..." rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info text-white">Post</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('imagePreview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
