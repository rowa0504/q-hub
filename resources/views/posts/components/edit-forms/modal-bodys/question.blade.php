<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Question Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="question-title-{{ $post->id }}" name="title" required placeholder='Start your question with “What”, “How”, etc.'>
              @error('title')
                  <p class="text-danger small">{{ $message }}</p>
              @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Question Body</label>
            <textarea class="form-control" id="question-description-{{ $post->id }}" name="description" rows="5" required></textarea>
              @error('description')
                  <p class="text-danger small">{{ $message }}</p>
              @enderror
          </div>

          <!-- Image preview -->
          <div class="mb-3 text-center">
              <img id="question-imagePreview-{{ $post->id }}" src="https://via.placeholder.com/300x200" alt="Image Preview"
                  class="img-fluid rounded">
          </div>

          <!-- File input -->
          <div class="mb-3">
              <input class="form-control" type="file" name="image" id="question-imageInput-{{ $post->id }}" accept="image/*">
              @error('image')
                  <p class="text-danger small">{{ $message }}</p>
              @enderror
          </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-warning"
            data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning text-white">Edit</button>

        <input type="hidden" name="category_id" value="7">
    </div>
</form>

  <script>
    document.getElementById('question-imageInput-{{ $post->id }}').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('question-imagePreview-{{ $post->id }}').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    $('.btn-edit').on('click', function () {
        const postId = $(this).data('id');
        const categoryId = $(this).data('category-id');

        // サーバーから投稿データを取得
        $.get(`/posts/${postId}/edit`, function (data) {

            // フォームへのデータの流し込み
            $('#question-title-{{ $post->id }}').val(data.title || '');
            $('#question-description-{{ $post->id }}').val(data.description || '');

            // 画像プレビュー（Base64データを使って表示）
            if (data.image && data.image.startsWith('data:image')) {
                $('#question-imagePreview-{{ $post->id }}').attr('src', data.image);
            } else {
                $('#question-imagePreview-{{ $post->id }}').attr('src', 'https://via.placeholder.com/300x200');
            }
        });
    });

</script>
