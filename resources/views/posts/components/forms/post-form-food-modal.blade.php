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
                        <img id="imagePreview2" src="https://via.placeholder.com/300x200" alt="Image Preview"
                            class="img-fluid rounded">
                    </div>

                    <!-- File input -->
                    <div class="mb-3">
                        <input class="form-control" type="file" name="image" id="imageInput2" accept="image/*">
                        @error('image')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" name="location" id="location-2"
                            placeholder="Location">
                        <input type="hidden" id="latitude-2" name="latitude">
                        <input type="hidden" id="longitude-2" name="longitude">
                        <div id="map-2" style="height: 300px;" class="mt-3 rounded border"></div>
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
                        <textarea class="form-control" name="description" id="description-2" placeholder="Enter your post description..."
                            rows="3"></textarea>
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
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places"></script>

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

    let map2;
    let marker2;

    function initAutocomplete2() {
        console.log("initAutocomplete2() called");
        const input = document.getElementById('location-2');
        const mapElement = document.getElementById('map-2');

        if (!mapElement) {
            console.error("map-2 element not found");
            return;
        }

        const defaultLocation = {
            lat: 13.41,
            lng: 122.56
        };

        map2 = new google.maps.Map(mapElement, {
            center: defaultLocation,
            zoom: 6,
        });

        marker2 = new google.maps.Marker({
            map: map2,
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

            map2.setCenter(location);
            map2.setZoom(15);
            marker2.setPosition(location);

            document.getElementById('latitude-2').value = location.lat();
            document.getElementById('longitude-2').value = location.lng();
        });
    }
</script>
