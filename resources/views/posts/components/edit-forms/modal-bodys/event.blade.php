<div class="modal-header">
    <h5 class="modal-title" id="otherPostModalLabel">Edit Event Post</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="modal-body">
        <!-- Image preview container -->
        <div class="mb-3 text-center">
            <div class="image-scroll-wrapper">
                <div class="image-scroll-container" id="imagePreviewContainer-{{ $post->id }}"></div>
                <div class="scroll-indicators" id="imagePreviewIndicators-{{ $post->id }}"></div>
            </div>
        </div>

        <div class="mb-3">
            <input class="form-control" type="file" name="images[]" id="imageInput-{{ $post->id }}" accept="image/*" multiple>
            @error('images')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Max input -->
        <div class="mb-3">
            <input type="number" name="max" id="event-max-{{ $post->id }}" class="form-control" placeholder="max" value="{{ old('max', $post->max) }}">
            @error('max')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Startdate input -->
        <div class="mb-3">
            <input type="date" class="form-control" id="event-startdate-{{ $post->id }}" name="startdate"
                value="{{ old('startdate', optional($post->startdate)->format('Y-m-d')) }}">
            @error('startdate')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Enddate input -->
        <div class="mb-3">
            <input type="date" class="form-control" id="event-enddate-{{ $post->id }}" name="enddate"
                value="{{ old('enddate', optional($post->enddate)->format('Y-m-d')) }}">
            @error('enddate')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <textarea class="form-control" name="description" id="event-description-{{ $post->id }}" rows="3" placeholder="Enter your post description...">{{ old('description', $post->description) }}</textarea>
            @error('description')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning text-white">Edit</button>
        <input type="hidden" name="category_id" value="1">
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modals = document.querySelectorAll('.modal');

    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', async function () {
            const postId = modal.dataset.postId;
            const input = modal.querySelector(`#imageInput-${postId}`);
            const previewContainer = modal.querySelector(`#imagePreviewContainer-${postId}`);
            const indicatorsContainer = modal.querySelector(`#imagePreviewIndicators-${postId}`);

            previewContainer.innerHTML = '';
            indicatorsContainer.innerHTML = '';

            try {
                const response = await fetch(`/posts/${postId}/images`);
                const data = await response.json();

                data.images.forEach((base64, index) => {
                    const img = document.createElement('img');
                    img.src = base64;
                    img.alt = `Existing Image ${index + 1}`;
                    img.classList.add('preview-image');
                    previewContainer.appendChild(img);

                    const dot = document.createElement('span');
                    dot.classList.add('indicator-dot');
                    if (index === 0) dot.classList.add('active');
                    indicatorsContainer.appendChild(dot);

                    dot.addEventListener('click', () => {
                        previewContainer.scrollTo({
                            left: img.offsetLeft,
                            behavior: 'smooth'
                        });
                    });
                });
            } catch (e) {
                console.error('画像取得に失敗しました', e);
            }

            const newInput = input.cloneNode(true);
            input.replaceWith(newInput);
            newInput.addEventListener('change', (e) => handleImagePreview(e, previewContainer, indicatorsContainer));
        });
    });

    function handleImagePreview(e, previewContainer, indicatorsContainer) {
        const files = e.target.files;
        if (!files.length) return;

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.alt = `New Image ${index + 1}`;
                img.classList.add('preview-image');
                previewContainer.appendChild(img);

                const dot = document.createElement('span');
                dot.classList.add('indicator-dot');
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
    }
});
</script>

