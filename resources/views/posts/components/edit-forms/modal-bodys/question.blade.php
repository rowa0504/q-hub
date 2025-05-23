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
            <input type="text" class="form-control" id="question-title-{{ $post->id }}" name="title" placeholder='Start your question with “What”, “How”, etc.'>
              @error('title')
                  <p class="text-danger small">{{ $message }}</p>
              @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Question Body</label>
            <textarea class="form-control" id="question-description-{{ $post->id }}" name="description" rows="5"></textarea>
              @error('description')
                  <p class="text-danger small">{{ $message }}</p>
              @enderror
          </div>

          <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="question-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

          <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="question-imageInput-{{ $post->id }}" accept="image/*" multiple>
            <div class="form-text text-start">
                Acceptable formats: jpeg, jpg, png, gif only<br>Max file size is 2048kB<br>Up to 3 images
            </div>
            @error('images')
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

<!-- jQueryを先に読み込む -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    $(document).on('click', '.btn-edit', function () {
        const postId = $(this).data('id');
        console.log('Edit button clicked, postId:', postId);

        const imagePreviewWrapper = document.getElementById(`question-imagePreviewWrapper-${postId}`);
        const scrollIndicators = document.getElementById(`scrollIndicators-${postId}`);
        const imageInput = document.getElementById(`question-imageInput-${postId}`);

        imagePreviewWrapper.innerHTML = '';
        scrollIndicators.innerHTML = '';

        // イベントリスナーの多重登録防止
        const newInput = imageInput.cloneNode(true);
        imageInput.replaceWith(newInput);

        newInput.addEventListener('change', function (e) {
            const files = e.target.files;

            imagePreviewWrapper.innerHTML = '';
            scrollIndicators.innerHTML = '';
            if (!files.length) return;

            const totalFiles = files.length;
            let loadedCount = 0;

            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.className = 'img-fluid rounded mb-2 me-2';
                    img.style.maxWidth = '400px';
                    img.style.height = '300px';
                    img.style.objectFit = 'cover';
                    imagePreviewWrapper.appendChild(img);

                    loadedCount++;
                    if (loadedCount === totalFiles) {
                        const imgCount = imagePreviewWrapper.querySelectorAll('img').length;
                        if (imgCount > 0) {
                            createIndicators(imagePreviewWrapper, scrollIndicators, imgCount);
                        }
                    }
                };
                reader.readAsDataURL(file);
            });
        });

        $.get(`/posts/${postId}/edit`)
            .done(function (data) {
                console.log('AJAX success:', data);
                if (!data) {
                    console.error('No data returned from server');
                    return;
                }

                $(`#question-title-${postId}`).val(data.post.title || '');
                $(`#question-description-${postId}`).val(data.post.description || '');

                if (data.images && data.images.length > 0) {
                    imagePreviewWrapper.innerHTML = '';
                    scrollIndicators.innerHTML = '';
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

        // スクロールでアクティブドット更新
        imagePreviewWrapper.addEventListener('scroll', () => {
            updateActiveIndicator(imagePreviewWrapper, scrollIndicators);
        });
    });

    // ドット生成
    function createIndicators(wrapper, indicators, count) {
        indicators.innerHTML = '';
        for (let i = 0; i < count; i++) {
            const dot = document.createElement('span');
            dot.className = 'indicator-dot';
            if (i === 0) dot.classList.add('active');
            dot.dataset.index = i;
            indicators.appendChild(dot);

            dot.addEventListener('click', () => {
                const scrollX = i * 310; // 画像幅300 + gap10
                wrapper.scrollTo({ left: scrollX, behavior: 'smooth' });
            });
        }
    }

    // アクティブドット更新
    function updateActiveIndicator(wrapper, indicators) {
        const scrollLeft = wrapper.scrollLeft;
        const index = Math.round(scrollLeft / 310);
        const dots = indicators.querySelectorAll('.indicator-dot');
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[index]) dots[index].classList.add('active');
    }
});
</script>

