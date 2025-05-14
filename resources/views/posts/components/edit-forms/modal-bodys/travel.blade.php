<div class="modal-header">
    <h5 class="modal-title" id="travelPostModalLabel">Edit Travel Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <!-- Image preview -->
        <div class="mb-3 text-center">
            <img id="travel-imagePreview-{{ $post->id }}" src="https://via.placeholder.com/300x200"
                alt="Image Preview" class="img-fluid rounded">
        </div>

        <!-- File input -->
        <div class="mb-3">
            <input class="form-control" type="file" name="image" id="travel-imageInput-{{ $post->id }}"
                accept="image/*">
            @error('image')
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

<script>
    // Image preview
    document.getElementById('travel-imageInput-{{ $post->id }}').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('travel-imagePreview-{{ $post->id }}').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Editボタンがクリックされたときの処理
    $('.btn-edit').on('click', function() {
        const postId = $(this).data('id');

        $.get(`/posts/${postId}/edit`, function(data) {
            $('#travel-location-{{ $post->id }}').val(data.location || '');
            $('#travel-description-{{ $post->id }}').val(data.description || '');

            // 緯度・経度のセットを追加
            $('#latitude-{{ $post->id }}').val(data.latitude || '');
            $('#longitude-{{ $post->id }}').val(data.longitude || '');

            // 画像プレビュー
            if (data.image && data.image.startsWith('data:image')) {
                $('#travel-imagePreview-{{ $post->id }}').attr('src', data.image);
            } else {
                $('#travel-imagePreview-{{ $post->id }}').attr('src', 'https://via.placeholder.com/300x200');
            }

            // 緯度経度を設定してからマップ初期化（重要）
            initAutocompleteTravel(postId);
        });
    });

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

