<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Item Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="item-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="item-imageInput-{{ $post->id }}" accept="image/*" multiple>
            <div class="form-text text-start">
                Acceptable formats: jpeg, jpg, png, gif only<br>Max file size is 2048kB<br>Up to 3 images
            </div>
            @error('images')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Max input --}}
        <div class="mb-3">
            <input type="number" name="max" id="item-max-{{ $post->id }}" class="form-control" placeholder="max">
            @error('max')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Startdate input --}}
        <div class="mb-3">
            <input type="date" class="form-control" id="item-startdate-{{ $post->id }}" name="startdate">
            @error('startdate')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Enddate input --}}
        <div class="mb-3">
            <input type="date" class="form-control" id="item-enddate-{{ $post->id }}" name="enddate">
            @error('enddate')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description input -->
        <div class="mb-3">
            <textarea class="form-control" name="description" id="item-description-{{ $post->id }}" placeholder="Enter your post description..." rows="3"></textarea>
            @error('description')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary"
            data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning text-white">Edit</button>

        <input type="hidden" name="category_id" value="3">
    </div>
</form>

<script>
$(document).on('click', '.btn-edit', function () {
    const postId = $(this).data('id');
    const imageInput = document.getElementById(`item-imageInput-${postId}`);
    const imagePreviewWrapper = document.getElementById(`item-imagePreviewWrapper-${postId}`);
    const scrollIndicators = document.getElementById(`scrollIndicators-${postId}`);

    // 初期化
    imagePreviewWrapper.innerHTML = '';
    scrollIndicators.innerHTML = '';

    // File input の再登録（changeイベントを確実に付け直す）
    const newImageInput = imageInput.cloneNode(true);
    imageInput.parentNode.replaceChild(newImageInput, imageInput);

    newImageInput.addEventListener('change', function (e) {
        const files = e.target.files;
        imagePreviewWrapper.innerHTML = '';
        scrollIndicators.innerHTML = '';
        if (!files.length) return;

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'img-fluid rounded mb-2 me-2';
                img.style.maxWidth = '400px';
                img.style.height = '300px';
                img.style.objectFit = 'cover';
                imagePreviewWrapper.appendChild(img);

                if (index === files.length - 1) {
                    createIndicators(imagePreviewWrapper, scrollIndicators, files.length);
                }
            };
            reader.readAsDataURL(file);
        });
    });

    // 既存データ取得
    $.get(`/posts/${postId}/edit`)
        .done(function (data) {
            function formatDate(date) {
                const d = new Date(date);
                if (isNaN(d.getTime())) return '';
                return d.toISOString().split('T')[0];
            }

            $(`#item-description-${postId}`).val(data.post.description || '');
            $(`#item-startdate-${postId}`).val(formatDate(data.post.startdatetime) || '');
            $(`#item-enddate-${postId}`).val(formatDate(data.post.enddatetime) || '');
            $(`#item-max-${postId}`).val(data.post.max || '');

            if (data.images && data.images.length > 0) {
                data.images.forEach(base64Img => {
                    if (base64Img.startsWith('data:image')) {
                        const img = document.createElement('img');
                        img.src = base64Img;
                        img.className = 'img-fluid rounded mb-2 me-2';
                        img.style.maxWidth = '400px';
                        img.style.height = '300px';
                        img.style.objectFit = 'cover';
                        imagePreviewWrapper.appendChild(img);
                    }
                });
                createIndicators(imagePreviewWrapper, scrollIndicators, data.images.length);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX failed:', textStatus, errorThrown);
        });

    // スクロールイベント再登録
    imagePreviewWrapper.addEventListener('scroll', () => {
        updateActiveIndicator(imagePreviewWrapper, scrollIndicators);
    });
});
</script>
