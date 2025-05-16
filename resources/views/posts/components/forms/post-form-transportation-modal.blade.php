<!--  postFormModal を追加 -->
<div class="modal fade" id="post-form-5" tabindex="-1" aria-labelledby="otherPostModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
        <div class="modal-header">
            <h5 class="modal-title" id="otherPostModalLabel">Create Transportation Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="modal-body">
                <!-- Image preview -->
                <div class="mb-3 text-center">
                    <div class="image-scroll-wrapper">
                        <div class="image-scroll-container" id="imagePreviewContainer5"></div>
                        <div class="scroll-indicators" id="imagePreviewIndicators5"></div>
                    </div>
                </div>

                <!-- File input -->
                <div class="mb-3">
                    <input class="form-control" type="file" name="images[]" id="imageInput5" accept="image/*" value="{{ old('image') }}" multiple>
                    @error('images')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fee input --}}
                <div class="mb-3">
                    <input type="number" class="form-control" name="fee" id="fee" value="{{ old('fee') }}" placeholder="fee (₱)" min="1" step="1">
                    @error('fee')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Transportation input --}}
                <div class="mb-3">
                    @if (!empty($all_trans_categories))
                        <select name="trans_category" id="trans_category">
                            <option value="" {{ old('trans_category') ? '' : 'selected' }}>Select transportation</option>
                            @foreach ($all_trans_categories as $trans_category)
                                <option value="{{ $trans_category->id }}"
                                    {{ old('trans_category') == $trans_category->id ? 'selected' : '' }}>
                                    {{ $trans_category->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    @error('trans_category')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deporture input --}}
                <div class="mb-3">
                    <input type="text" class="form-control" name="departure" id="departure" placeholder="departure" value="{{ old('departure') }}">
                    @error('departure')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Destination input --}}
                <div class="mb-3">
                    <input type="text" class="form-control" name="destination" id="destination" placeholder="destination" value="{{ old('destination') }}">
                    @error('destination')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description input -->
                <div class="mb-3">
                    <textarea class="form-control" name="description" id="description" placeholder="Enter your post description..." rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info text-white">Post</button>

                <input type="hidden" name="category_id" value="5">
            </div>
        </form>
    </div>
</div>
</div>

<script>
document.getElementById('imageInput5').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('imagePreviewContainer5');
    const indicatorsContainer = document.getElementById('imagePreviewIndicators5');
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
