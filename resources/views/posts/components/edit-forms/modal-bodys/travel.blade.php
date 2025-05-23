<div class="modal-header">
    <h5 class="modal-title" id="travelPostModalLabel">Edit Travel Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="travel-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="travel-imageInput-{{ $post->id }}" accept="image/*" multiple>
            <div class="form-text text-start">
                Acceptable formats: jpeg, jpg, png, gif only<br>Max file size is 2048kB<br>Up to 3 images
            </div>
            @error('images')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location input -->
        <div class="mb-3">
            <input type="text" class="form-control" name="location" id="travel-location-{{ $post->id }}"
                placeholder="Enter a location...">
            <input type="hidden" id="latitude-{{ $post->id }}" name="latitude">
            <input type="hidden" id="longitude-{{ $post->id }}" name="longitude">

            <!-- 地図を表示する要素 -->
            <div id="map-travel-{{ $post->id }}" style="height: 300px; width: 100%;" class="mt-2 rounded shadow-sm">
            </div>

            @error('location')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            @error('latitude')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            @error('longitude')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>


        <!-- Description input -->
        <div class="mb-3">
            <textarea class="form-control" name="description" id="travel-description-{{ $post->id }}"
                placeholder="Enter your post description..." rows="3"></textarea>
            @error('description')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning text-white">Edit</button>
        <input type="hidden" name="category_id" value="4">
    </div>
</form>

<!-- jQueryを先に読み込む -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Google Maps Autocomplete
    function initAutocompleteTravel(postId) {
        const input = document.getElementById('travel-location-' + postId);
        const mapElement = document.getElementById('map-travel-' + postId);
        if (!input || !mapElement) return;

        const defaultLocation = {
            lat: 13.41,
            lng: 122.56
        }; // フィリピン中央あたり

        const map = new google.maps.Map(mapElement, {
            center: defaultLocation,
            zoom: 6
        });

        const marker = new google.maps.Marker({
            map: map,
            position: defaultLocation,
            draggable: false
        });

        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: {
                country: 'ph'
            }
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const location = place.geometry.location;
            map.setCenter(location);
            map.setZoom(15);
            marker.setPosition(location);

            document.getElementById('latitude-' + postId).value = location.lat();
            document.getElementById('longitude-' + postId).value = location.lng();
        });
    }

    // モーダルが表示されたときにGoogle Mapsオートコンプリート初期化
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('edit-form-{{ $post->id }}');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function() {
                initAutocompleteTravel('{{ $post->id }}');
            });
        }
    });
</script>

<script>
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

    // スクロールイベント登録済みか管理
    const scrollEventRegistered = {};

    // 編集ボタンクリック時の処理
    $(document).on('click', '.btn-edit', function () {
        const postId = $(this).data('id');
        const wrapper = document.getElementById(`travel-imagePreviewWrapper-${postId}`);
        const indicators = document.getElementById(`scrollIndicators-${postId}`);

        wrapper.innerHTML = '';
        indicators.innerHTML = '';

        $.get(`/posts/${postId}/edit`)
            .done(function (data) {
                $(`#travel-description-${postId}`).val(data.post.description || '');
                $(`#travel-location-${postId}`).val(data.post.location || '');
                $(`#latitude-${postId}`).val(data.post.latitude || '');
                $(`#longitude-${postId}`).val(data.post.longitude || '');

                if (data.images && data.images.length > 0) {
                    data.images.forEach((base64Img, index) => {
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

                // スクロールイベントを一度だけ登録
                if (!scrollEventRegistered[postId]) {
                    wrapper.addEventListener('scroll', () => {
                        updateActiveIndicator(wrapper, indicators);
                    });
                    scrollEventRegistered[postId] = true;
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX failed:', textStatus, errorThrown);
            });
    });

    // ファイル選択時のプレビュー表示（動的登録）
    $(document).on('change', 'input[type="file"][id^="travel-imageInput-"]', function (e) {
        const input = e.target;
        const postId = input.id.replace('travel-imageInput-', '');
        const wrapper = document.getElementById(`travel-imagePreviewWrapper-${postId}`);
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
