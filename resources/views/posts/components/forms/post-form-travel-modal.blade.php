<!--  postFormModal を追加 -->
<div class="modal fade" id="post-form-4" tabindex="-1" aria-labelledby="otherPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="otherPostModalLabel">Create Travel Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <!-- Image preview -->
                    <div class="mb-3 text-center">
                        <img id="imagePreview4" src="https://via.placeholder.com/300x200" alt="Image Preview"
                            class="img-fluid rounded">
                    </div>

                    <!-- File input -->
                    <div class="mb-3">
                        <input class="form-control" type="file" name="image" id="imageInput4" accept="image/*">
                        @error('image')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location input -->
                    <div class="mb-3">
                        <!-- Location input -->
                        <div class="mb-3">
                            <input type="text" class="form-control" name="location" id="location-4"
                                placeholder="location">
                            <input type="hidden" id="latitude-4" name="latitude">
                            <input type="hidden" id="longitude-4" name="longitude">
                            @error('location')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description input -->
                    <div class="mb-3">
                        <textarea class="form-control" name="description" id="description" placeholder="Enter your post description..."
                            rows="3"></textarea>
                        @error('description')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="category_id" value="4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info text-white">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageInput4').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('imagePreview4').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Google Maps Autocomplete 初期化（Travel Post用）
    function initAutocomplete4() {
        const input = document.getElementById('location-4');
        if (!input) return;

        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: {
                country: 'ph'
            }
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            document.getElementById('latitude-4').value = place.geometry.location.lat();
            document.getElementById('longitude-4').value = place.geometry.location.lng();
        });
    }

    // モーダル表示時に初期化
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('post-form-4');

        if (modal) {
            modal.addEventListener('shown.bs.modal', function() {
                initAutocomplete4();
            });
        }
    });
</script>


