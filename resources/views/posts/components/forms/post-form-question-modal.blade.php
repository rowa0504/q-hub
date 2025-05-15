<!-- resources/views/questions/modal/add_questions.blade.php -->
<div class="modal fade" id="post-form-6" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addQuestionModalLabel">Create Question Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder='Start your question with “What”, “How”, etc.' value="{{ old('title') }}">
                @error('title')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Question Body</label>
              <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image preview -->
            <div class="mb-3 text-center">
                <div class="image-scroll-wrapper">
                    <div class="image-scroll-container" id="imagePreviewContainer6"></div>
                    <div class="scroll-indicators" id="imagePreviewIndicators6"></div>
                </div>
            </div>

            <!-- File input -->
            <div class="mb-3">
                <input class="form-control" type="file" name="images[]" id="imageInput6" accept="image/*" value="{{ old('image') }}" multiple>
                @error('images')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-end">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

              <input type="hidden" name="category_id" value="6">
              <button type="submit" class="btn btn-primary">Add Question</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
document.getElementById('imageInput6').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('imagePreviewContainer6');
    const indicatorsContainer = document.getElementById('imagePreviewIndicators6');
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
