<!-- Travel Post Modal -->
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
                        <div class="image-scroll-wrapper">
                            <div class="image-scroll-container" id="imagePreviewContainer4"></div>
                            <div class="scroll-indicators" id="imagePreviewIndicators4"></div>
                        </div>
                    </div>

                    <!-- File input -->
                    <div class="mb-3">
                        <input class="form-control" type="file" name="images[]" id="imageInput4" accept="image/*" value="{{ old('image') }}" multiple>
                        @error('images')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" name="location" id="location-4" placeholder="Location">
                        <input type="hidden" id="latitude-4" name="latitude">
                        <input type="hidden" id="longitude-4" name="longitude">
                        <div id="map-4" style="height: 300px;" class="mb-3 rounded"></div>
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
                        <textarea class="form-control" name="description" placeholder="Enter your post description..." rows="3"></textarea>
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

    // map4とmarker4を外に出す
    let map4;
    let marker4;

    function initAutocomplete4() {
        const input = document.getElementById('location-4');
        const mapElement = document.getElementById('map-4');

        const defaultLocation = { lat: 13.41, lng: 122.56 }; // フィリピン中央

        map4 = new google.maps.Map(mapElement, {
            center: defaultLocation,
            zoom: 6,
        });

        marker4 = new google.maps.Marker({
            map: map4,
            position: defaultLocation,
            draggable: false
        });

        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'],
            componentRestrictions: { country: 'ph' }
        });

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const location = place.geometry.location;

            map4.setCenter(location);
            map4.setZoom(15);
            marker4.setPosition(location);

            document.getElementById('latitude-4').value = location.lat();
            document.getElementById('longitude-4').value = location.lng();
        });
    }

    // モーダルが開いたときに地図を初期化
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('post-form-4');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function () {
                setTimeout(() => {
                    initAutocomplete4();
                }, 500); // 少し待つことで描画不具合を防ぐ
            });
        }
    });

document.getElementById('imageInput4').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('imagePreviewContainer4');
    const indicatorsContainer = document.getElementById('imagePreviewIndicators4');
    previewContainer.innerHTML = '';
    indicatorsContainer.innerHTML = '';

    const files = e.target.files;
    if (!files.length) return;

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.alt = `Preview Image ${index + 1}`;
            previewContainer.appendChild(img);

            const dot = document.createElement('span');
            dot.classList.add('indicator-dot');
            if(index === 0) dot.classList.add('active');
            indicatorsContainer.appendChild(dot);

            dot.addEventListener('click', () => {
                previewContainer.scrollTo({
                    left: img.offsetLeft,
                    behavior: 'smooth'
                });
            });
        };
        reader.readAsDataURL(file);
    });

    previewContainer.addEventListener('scroll', () => {
        const scrollLeft = previewContainer.scrollLeft;
        let closestIndex = 0;
        let minDistance = Infinity;
        previewContainer.querySelectorAll('img').forEach((img, i) => {
            const distance = Math.abs(img.offsetLeft - scrollLeft);
            if(distance < minDistance){
                minDistance = distance;
                closestIndex = i;
            }
        });

        indicatorsContainer.querySelectorAll('.indicator-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === closestIndex);
        });
    });
});
</script>
