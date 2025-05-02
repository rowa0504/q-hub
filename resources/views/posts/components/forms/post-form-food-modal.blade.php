<!-- モーダル -->
<div class="modal fade" id="post-form-2" tabindex="-1" aria-labelledby="foodPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-4">
        <div class="modal-header">
          <h5 class="modal-title" id="foodPostModalLabel">Create Food Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <!-- 画像 -->
            <div class="mb-3 text-center">
              <img id="imagePreview2" src="https://via.placeholder.com/300x200" alt="Preview" class="img-fluid rounded">
            </div>
            <div class="mb-3">
              <input class="form-control" type="file" name="image" id="imageInput2" accept="image/*">
            </div>

            <!-- タイトル -->
            <div class="mb-3">
              <input type="text" name="title" class="form-control" placeholder="Enter title">
            </div>

            <!-- 住所（オートコンプリート） -->
            <div class="mb-3">
              <input type="text" id="location-input-2" name="location" class="form-control" placeholder="Enter a location...">
              <input type="hidden" id="latitude-2" name="latitude">
              <input type="hidden" id="longitude-2" name="longitude">
            </div>

            <!-- 説明 -->
            <div class="mb-3">
              <textarea name="description" class="form-control" rows="3" placeholder="Description..."></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-info text-white">Post</button>
            <input type="hidden" name="category_id" value="2">
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
    // プレビュー表示
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

    // モーダルが表示されたときにオートコンプリートを初期化
    // Google Maps APIの初期化
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('post-form-2');

    modal.addEventListener('shown.bs.modal', function () {
      initAutocomplete();
    });

    // プレビュー画像
    document.getElementById('imageInput2').addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
          document.getElementById('imagePreview2').src = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  });

  function initAutocomplete() {
    const input = document.getElementById('location-input-2');
    if (!input) return;

    const autocomplete = new google.maps.places.Autocomplete(input, {
      types: ['geocode'],
      componentRestrictions: { country: 'ph' }
    });

    autocomplete.addListener('place_changed', function () {
      const place = autocomplete.getPlace();
      if (!place.geometry) return;

      document.getElementById('latitude-2').value = place.geometry.location.lat();
      document.getElementById('longitude-2').value = place.geometry.location.lng();
    });
  }

</script>
