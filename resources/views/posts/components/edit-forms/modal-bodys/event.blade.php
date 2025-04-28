<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Event Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <!-- Image preview -->
        <div class="mb-3 text-center">
            <img id="event-imagePreview-{{ $post->id }}" src="https://via.placeholder.com/300x200" alt="Image Preview"
                class="img-fluid rounded">
        </div>

        <!-- File input -->
        <div class="mb-3">
            <input class="form-control" type="file" name="image" id="event-imageInput-{{ $post->id }}" accept="image/*">
            @error('image')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Max input --}}
        <div class="mb-3">
            <input type="number" name="max" id="event-max-{{ $post->id }}" class="form-control" placeholder="max">
            @error('max')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Startdate input --}}
        <div class="mb-3">
            <input type="date" class="form-control" id="event-startdate-{{ $post->id }}" name="startdate">
            @error('startdate')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Enddate input --}}
        <div class="mb-3">
            <input type="date" class="form-control" id="event-enddate-{{ $post->id }}" name="enddate">
            @error('enddate')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Title input -->
        <div class="mb-3">
            <input type="text" class="form-control" name="title" id="event-title-{{ $post->id }}" placeholder="Enter your post title...">
            @error('title')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description input -->
        <div class="mb-3">
            <textarea class="form-control" name="description" id="event-description-{{ $post->id }}" placeholder="Enter your post description..." rows="3"></textarea>
            @error('description')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary"
            data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning text-white">Edit</button>

        <input type="hidden" name="category_id" value="1">
    </div>
</form>

<script>
    document.getElementById('event-imageInput-{{ $post->id }}').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('event-imagePreview-{{ $post->id }}').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    $('.btn-edit').on('click', function () {
        const postId = $(this).data('id');
        const categoryId = $(this).data('category-id');

        // サーバーから投稿データを取得
        $.get(`/posts/${postId}/edit`, function (data) {

            function formatDate(date) {
                const d = new Date(date);
                if (isNaN(d.getTime())) {
                    return ''; // 無効な日付の場合は空文字を返す
                }
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;  // 修正: YYYY-MM-DD 形式に変更
            }
            // フォームへのデータの流し込み
            $('#event-title-{{ $post->id }}').val(data.title || '');
            $('#event-description-{{ $post->id }}').val(data.description || '');
            $('#event-startdate-{{ $post->id }}').val(formatDate(data.startdatetime) || '');
            $('#event-enddate-{{ $post->id }}').val(formatDate(data.enddatetime) || '');
            $('#event-max-{{ $post->id }}').val(data.max || '');

            // 画像プレビュー（Base64データを使って表示）
            if (data.image && data.image.startsWith('data:image')) {
                $('#event-imagePreview-{{ $post->id }}').attr('src', data.image);
            } else {
                $('#event-imagePreview-{{ $post->id }}').attr('src', 'https://via.placeholder.com/300x200');
            }
        });
    });

</script>
