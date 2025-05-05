<!-- postFormModal を追加 -->
<div class="modal fade" id="post-form-2" tabindex="-1" aria-labelledby="otherPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="otherPostModalLabel">Create Food Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <!-- Image preview -->
                    <div class="mb-3 text-center">
                        <img id="imagePreview2" src="https://via.placeholder.com/300x200" alt="Image Preview" class="img-fluid rounded">
                    </div>

                    <!-- File input -->
                    <div class="mb-3">
                        <input class="form-control" type="file" name="image" id="imageInput2" accept="image/*">
                        @error('image')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" name="title" id="title-2" placeholder="Enter your post title...">
                        @error('title')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" name="location" id="location-2" placeholder="Location">
                        <input type="hidden" id="latitude-2" name="latitude">
                        <input type="hidden" id="longitude-2" name="longitude">
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
                        <textarea class="form-control" name="description" id="description-2" placeholder="Enter your post description..." rows="3"></textarea>
                        @error('description')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="category_id" value="2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info text-white">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Google Maps JavaScript API -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMuLHnV2h0BxRv9qXGV22-Z5rG3jG9Mc&libraries=places&callback=initAutocomplete">
</script>

<script>
    // プレビュー画像表示処理
    document.getElementById('imageInput2').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('imagePreview2').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Google Maps Autocomplete（Food用）
    function initAutocomplete() {
        const input = document.getElementById('location-2');
        if (!input) return;

        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: { country: 'ph' }
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            document.getElementById('latitude-2').value = place.geometry.location.lat();
            document.getElementById('longitude-2').value = place.geometry.location.lng();
        });
    }

    // モーダル表示時にオートコンプリートを初期化
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('post-form-2');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function() {
                initAutocomplete();
            });
        }
    });
</script>
