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
            $('#travel-location-' + postId).val(data.location || '');
            $('#travel-description-' + postId).val(data.description || '');

            if (data.image && data.image.startsWith('data:image')) {
                $('#travel-imagePreview-' + postId).attr('src', data.image);
            } else {
                $('#travel-imagePreview-' + postId).attr('src', 'https://via.placeholder.com/300x200');
            }
        });
    });

    // Google Maps Autocomplete
    function initAutocompleteTravel(postId) {
        const input = document.getElementById('travel-location-' + postId);
        if (!input) return;

        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: { country: 'ph' }
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;
            document.getElementById('latitude-' + postId).value = place.geometry.location.lat();
            document.getElementById('longitude-' + postId).value = place.geometry.location.lng();
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
