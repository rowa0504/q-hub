<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Transportation Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <!-- Image preview -->
        {{-- <div class="mb-3 text-center">
            <img id="transportation-imagePreview-{{ $post->id }}" src="https://via.placeholder.com/300x200" alt="Image Preview" class="img-fluid rounded">
        </div> --}}

        <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="transportation-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

        <!-- File input -->
        {{-- <div class="mb-3">
            <input class="form-control" type="file" name="image" id="transportation-imageInput-{{ $post->id }}" accept="image/*">
            @error('image')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div> --}}

        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="transportation-imageInput-{{ $post->id }}" accept="image/*" multiple>
            @error('images')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fee input --}}
        <div class="mb-3">
            <input type="number" class="form-control" name="fee" id="transportation-fee-{{ $post->id }}" placeholder="fee (₱)" min="1" step="1">
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
                        @else
                            <option value="{{ $trans_category->id }}">{{ $trans_category->name }}</option>
                        @endif
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

{{-- <script>
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

</script> --}}

<script>
const postId = {{ $post->id }};
const imageInput = document.getElementById(`transportation-imageInput-${postId}`);
const imagePreviewWrapper = document.getElementById(`transportation-imagePreviewWrapper-${postId}`);
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
    imagePreviewWrapper.innerHTML = '';
    scrollIndicators.innerHTML = '';
    if (!files.length) return;

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.className = 'img-fluid rounded mb-2 me-2';
            img.style.maxWidth = '300px';
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
$(document).on('click', '.btn-edit', function () {
    const postId = $(this).data('id');
    console.log('Edit button clicked, postId:', postId);

    const imagePreviewWrapper = document.getElementById(`transportation-imagePreviewWrapper-${postId}`);
    const scrollIndicators = document.getElementById(`scrollIndicators-${postId}`);
    imagePreviewWrapper.innerHTML = '';
    scrollIndicators.innerHTML = '';

    $.get(`/posts/${postId}/edit`)
        .done(function (data) {
            console.log('AJAX success:', data);
            if (!data) {
                console.error('No data returned from server');
                return;
            }

            function formatDate(date) {
                const d = new Date(date);
                if (isNaN(d.getTime())) return '';
                return d.toISOString().split('T')[0];
            }

            $(`#transportation-fee-${postId}`).val(data.post.fee || '');
            $(`#transportation-departure-${postId}`).val(data.post.departure || '');
            $(`#transportation-destination-${postId}`).val(data.post.destination || '');
            $(`#transportation-description-${postId}`).val(data.post.description || '');

            if (data.images && data.images.length > 0) {
                data.images.forEach(base64Img => {
                    if (base64Img.startsWith('data:image')) {
                        const img = document.createElement('img');
                        img.src = base64Img;
                        img.className = 'img-fluid rounded mb-2 me-2';
                        img.style.maxWidth = '300px';
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
