<!-- resources/views/questions/modal/add_questions.blade.php -->
<div class="modal fade" id="post-form-6" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addQuestionModalLabel">Create Question Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" required placeholder='Start your question with “What”, “How”, etc.'>
                @error('title')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Question Body</label>
              <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                @error('description')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image preview -->
            <div class="mb-3 text-center">
                <img id="imagePreview6" src="https://via.placeholder.com/300x200" alt="Image Preview"
                    class="img-fluid rounded">
            </div>

            <!-- File input -->
            <div class="mb-3">
                <input class="form-control" type="file" name="image" id="imageInput6" accept="image/*">
                @error('image')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-end">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

              <input type="hidden" name="category_id" value="6">
              <button type="submit" class="btn btn-primary">Add Question</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
document.getElementById('imageInput6').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('imagePreview6').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
