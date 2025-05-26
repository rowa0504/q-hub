<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Transportation Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="transportation-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="transportation-imageInput-{{ $post->id }}" accept="image/*" multiple>
            <div class="form-text text-start">
                Acceptable formats: jpeg, jpg, png, gif only<br>Max file size is 2048kB<br>Up to 3 images
            </div>
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
                <label class="form-label d-block text-start">Select transportation（select one）</label>
                @foreach ($all_trans_categories as $trans_category)
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="trans_category"
                            id="trans_category_{{ $trans_category->id }}"
                            value="{{ $trans_category->id }}"
                            @if(old('trans_category') !== null)
                                {{ old('trans_category') == $trans_category->id ? 'checked' : '' }}
                            @else
                                {{ (isset($post->transCategory) && $post->transCategory->id == $trans_category->id) ? 'checked' : '' }}
                            @endif
                        >
                        <label class="form-check-label" for="trans_category_{{ $trans_category->id }}">
                            @switch($trans_category->id)
                                @case(1)
                                    <i class="fas fa-motorcycle"></i> {{ $trans_category->name }}
                                    @break
                                @case(2)
                                    <i class="fas fa-car"></i> {{ $trans_category->name }}
                                    @break
                                @case(3)
                                    <i class="fas fa-bus"></i> {{ $trans_category->name }}
                                    @break
                                @default
                                    <i class="fas fa-question"></i> {{ $trans_category->name }}
                            @endswitch
                        </label>
                    </div>
                @endforeach
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

<!-- jQueryを先に読み込む -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const scrollEventRegistered = {};

    function createIndicators(wrapper, indicators, count) {
        indicators.innerHTML = '';
        for (let i = 0; i < count; i++) {
            const dot = document.createElement('span');
            dot.className = 'indicator-dot';
            if (i === 0) dot.classList.add('active');
            dot.dataset.index = i;
            indicators.appendChild(dot);

            dot.addEventListener('click', () => {
                const scrollX = i * 310;
                wrapper.scrollTo({ left: scrollX, behavior: 'smooth' });
            });
        }
    }

    function updateActiveIndicator(wrapper, indicators) {
        const scrollLeft = wrapper.scrollLeft;
        const index = Math.round(scrollLeft / 310);
        const dots = indicators.querySelectorAll('.indicator-dot');
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[index]) dots[index].classList.add('active');
    }

    // 編集ボタンをクリックしたとき
    $(document).on('click', '.btn-edit', function () {
        const postId = $(this).data('id');

        const wrapper = document.getElementById(`transportation-imagePreviewWrapper-${postId}`);
        const indicators = document.getElementById(`scrollIndicators-${postId}`);

        wrapper.innerHTML = '';
        indicators.innerHTML = '';

        $.get(`/posts/${postId}/edit`)
            .done(function (data) {
                $(`#transportation-fee-${postId}`).val(data.post.fee || '');
                $(`#transportation-departure-${postId}`).val(data.post.departure || '');
                $(`#transportation-destination-${postId}`).val(data.post.destination || '');
                $(`#transportation-description-${postId}`).val(data.post.description || '');

                if (data.images && data.images.length > 0) {
                    data.images.forEach((base64Img) => {
                        if (base64Img.startsWith('data:image')) {
                            const img = document.createElement('img');
                            img.src = base64Img;
                            img.className = 'img-fluid rounded mb-2 me-2';
                            img.style.maxWidth = '400px';
                            img.style.height = '300px';
                            img.style.objectFit = 'cover';
                            wrapper.appendChild(img);
                        }
                    });
                    createIndicators(wrapper, indicators, data.images.length);
                }

                // スクロールイベントは1回だけ登録
                if (!scrollEventRegistered[postId]) {
                    wrapper.addEventListener('scroll', () => {
                        updateActiveIndicator(wrapper, indicators);
                    });
                    scrollEventRegistered[postId] = true;
                }
            });
    });

    // 画像を選んだときの処理（新しい画像が選択されたときにプレビューを入れ替える）
    $(document).on('change', 'input[type="file"][id^="transportation-imageInput-"]', function () {
        const input = this;
        const postId = input.id.replace('transportation-imageInput-', '');

        const wrapper = document.getElementById(`transportation-imagePreviewWrapper-${postId}`);
        const indicators = document.getElementById(`scrollIndicators-${postId}`);

        wrapper.innerHTML = '';
        indicators.innerHTML = '';

        const files = input.files;
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
                wrapper.appendChild(img);

                if (index === files.length - 1) {
                    createIndicators(wrapper, indicators, files.length);
                }
            };
            reader.readAsDataURL(file);
        });
    });
</script>
