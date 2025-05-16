<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Event Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <!-- 複数画像のプレビュー表示枠 -->
        <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="event-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

        <!-- File input -->
        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="event-imageInput-{{ $post->id }}" accept="image/*" multiple>
            @error('images')
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

{{-- <script>
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

</script> --}}

<script>
const postId = {{ $post->id }};
const imageInput = document.getElementById(`event-imageInput-${postId}`);
const imagePreviewWrapper = document.getElementById(`event-imagePreviewWrapper-${postId}`);
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

    const imagePreviewWrapper = document.getElementById(`event-imagePreviewWrapper-${postId}`);
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

            $(`#event-description-${postId}`).val(data.post.description || '');
            $(`#event-startdate-${postId}`).val(formatDate(data.post.startdatetime) || '');
            $(`#event-enddate-${postId}`).val(formatDate(data.post.enddatetime) || '');
            $(`#event-max-${postId}`).val(data.post.max || '');

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

