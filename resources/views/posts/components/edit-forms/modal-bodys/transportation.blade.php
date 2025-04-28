<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Transportation Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <!-- Image preview -->
        <div class="mb-3 text-center">
            <img id="transportation-imagePreview-{{ $post->id }}" src="https://via.placeholder.com/300x200" alt="Image Preview" class="img-fluid rounded">
        </div>

        <!-- File input -->
        <div class="mb-3">
            <input class="form-control" type="file" name="image" id="transportation-imageInput-{{ $post->id }}" accept="image/*">
            @error('image')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Title input -->
        <div class="mb-3">
            <input type="text" class="form-control" name="title" id="transportation-title-{{ $post->id }}" placeholder="Enter your post title...">
            @error('title')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fee input --}}
        <div class="mb-3">
            <input type="number" class="form-control" name="fee" id="transportation-fee-{{ $post->id }}" placeholder="fee">
            @error('fee')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Transportation input --}}
        <div class="mb-3">
            @if (!empty($all_trans_categories))
                <select name="trans_category" id="trans_category">
                    @foreach ($all_trans_categories as $trans_category)
                        @if ($trans_category->id == $post->transCategory->id)
                            <option value="{{ $trans_category->id }}" selected>{{ $trans_category->name }}</option>
                        @endif
                        <option value="{{ $trans_category->id }}">{{ $trans_category->name }}</option>
                    @endforeach
                </select>
            @endif
            @error('trans_category')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Departure input --}}
        <div class="mb-3">
            <input type="text" class="form-control" name="departure" id="transportation-departure-{{ $post->id }}" placeholder="departure">
            @error('departure')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Destination input --}}
        <div class="mb-3">
            <input type="text" class="form-control" name="destination" id="transportation-destination-{{ $post->id }}" placeholder="destination">
            @error('destination')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description input -->
        <div class="mb-3">
            <textarea class="form-control" name="description" id="transportation-description-{{ $post->id }}" placeholder="Enter your post description..." rows="3"></textarea>
            @error('description')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-warning"
            data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning text-white">Edit</button>

        <input type="hidden" name="category_id" value="5">
    </div>
</form>

<script>
    document.getElementById('transportation-imageInput-{{ $post->id }}').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('transportation-imagePreview-{{ $post->id }}').src = event.target.result;
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
            $('#transportation-title-{{ $post->id }}').val(data.title || '');
            $('#transportation-fee-{{ $post->id }}').val(data.fee || '');
            $('#transportation-departure-{{ $post->id }}').val(data.departure || '');
            $('#transportation-destination-{{ $post->id }}').val(data.destination || '');
            $('#transportation-description-{{ $post->id }}').val(data.description || '');

            // 画像プレビュー（Base64データを使って表示）
            if (data.image && data.image.startsWith('data:image')) {
                $('#transportation-imagePreview-{{ $post->id }}').attr('src', data.image);
            } else {
                $('#transportation-imagePreview-{{ $post->id }}').attr('src', 'https://via.placeholder.com/300x200');
            }
        });
    });

</script>
