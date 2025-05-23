<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Other Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="other-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="other-imageInput-{{ $post->id }}" accept="image/*" multiple>
            <div class="form-text text-start">
                Acceptable formats: jpeg, jpg, png, gif only<br>Max file size is 2048kB<br>Up to 3 images
            </div>
            @error('images')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description input -->
        <div class="mb-3">
            <textarea class="form-control" name="description" id="other-description-{{ $post->id }}" placeholder="Enter your post description..." rows="3"></textarea>
            @error('description')
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
const postId = {{ $post->id }};
const imageInput = document.getElementById(`other-imageInput-${postId}`);
const imagePreviewWrapper = document.getElementById(`other-imagePreviewWrapper-${postId}`);
const scrollIndicators = document.getElementById(`scrollIndicators-${postId}`);

// プレビュー画像にドットを動的生成
function createIndicators(wrapper, indicators, count) {
    indicators.innerHTML = '';
    for (let i = 0; i < count; i++) {
        const dot = document.createElement('span');
        dot.className = 'indicator-dot';
        if (i === 0) dot.classList.add('active');
        dot.dataset.index = i;
        indicators.appendChild(dot);

        dot.addEventListener('click', () => {
            const scrollX = i * 310; // 画像幅300px + gap 10px
            wrapper.scrollTo({ left: scrollX, behavior: 'smooth' });
        });
    }
}

// アクティブドットを更新
function updateActiveIndicator(wrapper, indicators) {
    const scrollLeft = wrapper.scrollLeft;
    const index = Math.round(scrollLeft / 310);
    const dots = indicators.querySelectorAll('.indicator-dot');
    dots.forEach(dot => dot.classList.remove('active'));
    if (dots[index]) dots[index].classList.add('active');
}

// 選択画像のプレビュー（新規投稿時）
imageInput.addEventListener('change', function (e) {
    const files = e.target.files;
    imagePreviewWrapper.innerHTML = '';  // ここで既存画像をクリア
    scrollIndicators.innerHTML = '';      // インジケータもクリア
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

// 編集ボタンクリック時に既存データ取得＆モーダル初期化
// 重要：postIdごとにイベントハンドラを登録するのではなく、編集ボタンクリック後にイベントを登録する方式に切替え例

$(document).on('click', '.btn-edit', function () {
    const postId = $(this).data('id');
    console.log('Edit button clicked, postId:', postId);

    const imagePreviewWrapper = document.getElementById(`other-imagePreviewWrapper-${postId}`);
    const scrollIndicators = document.getElementById(`scrollIndicators-${postId}`);
    const imageInput = document.getElementById(`other-imageInput-${postId}`);
    const descriptionInput = document.getElementById(`other-description-${postId}`);

    // 既存のプレビューとインジケータをクリア
    imagePreviewWrapper.innerHTML = '';
    scrollIndicators.innerHTML = '';

    // 既存のchangeイベントを外す（念のため）
    imageInput.replaceWith(imageInput.cloneNode(true));
    const newImageInput = document.getElementById(`other-imageInput-${postId}`);

    // 新規画像選択時のプレビュー表示
    newImageInput.addEventListener('change', function (e) {
        const files = e.target.files;
        imagePreviewWrapper.innerHTML = '';  // 既存画像クリア
        scrollIndicators.innerHTML = '';      // インジケータもクリア
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

    // AJAXで既存投稿データ取得
    $.get(`/posts/${postId}/edit`)
        .done(function (data) {
            console.log('AJAX success:', data);
            if (!data) {
                console.error('No data returned from server');
                return;
            }
            descriptionInput.value = data.post.description || '';

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
});

// スクロール時にアクティブドット更新
imagePreviewWrapper.addEventListener('scroll', () => {
    updateActiveIndicator(imagePreviewWrapper, scrollIndicators);
});
</script>
