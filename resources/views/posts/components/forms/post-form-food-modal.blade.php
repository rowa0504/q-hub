<!-- Travel Post Modal -->
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
                        <div class="image-scroll-wrapper">
                            <div class="image-scroll-container" id="imagePreviewContainer2"></div>
                            <div class="scroll-indicators" id="imagePreviewIndicators2"></div>
                        </div>
                    </div>

                    <!-- File input -->
                    <div class="mb-3">
                        <input class="form-control" type="file" name="images[]" id="imageInput2" accept="image/*" value="{{ old('image') }}" multiple>
                        @error('images')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" name="location" id="location-2" placeholder="Location">
                        <input type="hidden" id="latitude-2" name="latitude">
                        <input type="hidden" id="longitude-2" name="longitude">
                        <div id="map-2" style="height: 300px;" class="mb-3 rounded"></div>
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
    // 画像プレビュー
    // document.getElementById('imageInput2').addEventListener('change', function (e) {
    //     const file = e.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function (event) {
    //             document.getElementById('imagePreview2').src = event.target.result;
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });

    // map2とmarker2を外に出す
    let map2;
    let marker2;

    function initAutocomplete2() {
        const input = document.getElementById('location-2');
        const mapElement = document.getElementById('map-2');

        const defaultLocation = { lat: 13.41, lng: 122.56 }; // フィリピン中央

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
            componentRestrictions: { country: 'ph' }
        });

        autocomplete.addListener('place_changed', function () {
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

document.getElementById('imageInput2').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('imagePreviewContainer2');
    const indicatorsContainer = document.getElementById('imagePreviewIndicators2');
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
    // モーダルが開いたときに地図を初期化
    // document.addEventListener('DOMContentLoaded', function () {
    //     const modal = document.getElementById('post-form-2');
    //     if (modal) {
    //         modal.addEventListener('shown.bs.modal', function () {
    //             setTimeout(() => {
    //                 initAutocomplete2();
    //             }, 500); // 少し待つことで描画不具合を防ぐ
    //         });
    //     }
    // });

</script>
