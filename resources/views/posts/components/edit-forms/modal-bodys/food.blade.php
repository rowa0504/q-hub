<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Food Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <!-- Image preview -->
        {{-- <div class="mb-3 text-center">
            <img id="food-imagePreview-{{ $post->id }}" src="https://via.placeholder.com/300x200"
                alt="Image Preview" class="img-fluid rounded">
        </div> --}}

        <div class="image-scroll-wrapper">
            <div class="image-scroll-container" id="food-imagePreviewWrapper-{{ $post->id }}">
                <!-- 画像がJSで挿入される -->
            </div>
            <div class="scroll-indicators" id="scrollIndicators-{{ $post->id }}"></div>
        </div>

        <!-- File input -->
        {{-- <div class="mb-3">
            <input class="form-control" type="file" name="image" id="food-imageInput-{{ $post->id }}"
                accept="image/*">
            @error('image')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div> --}}

        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="event-imageInput-{{ $post->id }}" accept="image/*" multiple>
            @error('images')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location input -->
        <div class="mb-3">
            <input type="text" id="food-location-{{ $post->id }}" name="location" class="form-control"
                placeholder="Enter a location...">
            <input type="hidden" id="latitude-{{ $post->id }}" name="latitude">
            <input type="hidden" id="longitude-{{ $post->id }}" name="longitude">
            <!-- Map Display -->
            <div id="map-{{ $post->id }}" style="height: 300px;" class="mb-3 rounded"></div>
            @error('latitude')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            @error('longitude')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            @error('location')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>


        <!-- Description input -->
        <div class="mb-3">
            <textarea class="form-control" name="description" id="food-description-{{ $post->id }}"
                placeholder="Enter your post description..." rows="3"></textarea>
            @error('description')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning text-white">Edit</button>

        <input type="hidden" name="category_id" value="2">
    </div>
</form>

<script>
    // document.getElementById('food-imageInput-{{ $post->id }}').addEventListener('change', function(e) {
    //     const file = e.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function(event) {
    //             document.getElementById('food-imagePreview-{{ $post->id }}').src = event.target.result;
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });
    // $('.btn-edit').on('click', function() {
    //     const postId = $(this).data('id');
    //     const categoryId = $(this).data('category-id');

    //     $.get(`/posts/${postId}/edit`, function(data) {
    //         $('#food-location-{{ $post->id }}').val(data.location || '');
    //         $('#food-description-{{ $post->id }}').val(data.description || '');

    //         // 緯度・経度のセットを追加
    //         $('#latitude-{{ $post->id }}').val(data.latitude || '');
    //         $('#longitude-{{ $post->id }}').val(data.longitude || '');

    //         // 画像プレビュー
    //         if (data.image && data.image.startsWith('data:image')) {
    //             $('#food-imagePreview-{{ $post->id }}').attr('src', data.image);
    //         } else {
    //             $('#food-imagePreview-{{ $post->id }}').attr('src',
    //                 'https://via.placeholder.com/300x200');
    //         }

    //         // 緯度経度を設定してからマップ初期化（重要）
    //         initAutocomplete();
    //     });
    // });


    // Google Maps Autocomplete（Food用）
    function initAutocomplete() {
        const input = document.getElementById('food-location-{{ $post->id }}');
        const mapElement = document.getElementById('map-{{ $post->id }}');
        const lat = parseFloat(document.getElementById('latitude-{{ $post->id }}').value);
        const lng = parseFloat(document.getElementById('longitude-{{ $post->id }}').value);

        if (!input || !mapElement) return;

        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: {
                country: 'ph'
            }
        });

        const defaultLocation = (!isNaN(lat) && !isNaN(lng)) ? {
            lat: lat,
            lng: lng
        } : {
            lat: 13.41,
            lng: 122.56
        };

        const map = new google.maps.Map(mapElement, {
            center: defaultLocation,
            zoom: (!isNaN(lat) && !isNaN(lng)) ? 15 : 6
        });

        const marker = new google.maps.Marker({
            map: map,
            position: (!isNaN(lat) && !isNaN(lng)) ? defaultLocation : null,
            visible: (!isNaN(lat) && !isNaN(lng))
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            document.getElementById('latitude-{{ $post->id }}').value = place.geometry.location.lat();
            document.getElementById('longitude-{{ $post->id }}').value = place.geometry.location.lng();

            map.setCenter(place.geometry.location);
            map.setZoom(15);

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });
    }
</script>

<script>
const postId = {{ $post->id }};
const imageInput = document.getElementById(`food-imageInput-${postId}`);
const imagePreviewWrapper = document.getElementById(`food-imagePreviewWrapper-${postId}`);
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

    const imagePreviewWrapper = document.getElementById(`food-imagePreviewWrapper-${postId}`);
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

            $(`#food-description-${postId}`).val(data.post.description || '');
            $(`#food-location-${postId}`).val(formatDate(data.post.location) || '');
            // 緯度・経度のセットを追加
            $(`#latitude-${postId}`).val(data.post.latitude || '');
            $(`#longitude-${postId}`).val(data.post.longitude || '');

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
