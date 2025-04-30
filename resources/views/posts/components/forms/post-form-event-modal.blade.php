<!--  postFormModal を追加 -->
<div class="modal fade" id="post-form-1" tabindex="-1" aria-labelledby="otherPostModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
        <div class="modal-header">
            <h5 class="modal-title" id="otherPostModalLabel">Create Event Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="modal-body">
                <!-- Image preview -->
                <div class="mb-3 text-center">
                    <img id="imagePreview1" src="https://via.placeholder.com/300x200" alt="Image Preview"
                        class="img-fluid rounded">
                </div>

                <!-- File input -->
                <div class="mb-3">
                    <input class="form-control" type="file" name="image" id="imageInput1" accept="image/*" value="{{ old('image') }}">
                    @error('image')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Max input --}}
                <div class="mb-3">
                    <input type="number" name="max" id="max" class="form-control" placeholder="max" value="{{ old('max') }}">
                    @error('max')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Startdate input --}}
                <div class="mb-3">
                    <input type="date" class="form-control" id="startdate" name="startdate" value="{{ old('startdate') }}">
                    @error('startdate')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Enddate input --}}
                <div class="mb-3">
                    <input type="date" class="form-control" id="enddate" name="enddate" value="{{ old('enddate') }}">
                    @error('enddate')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title input -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter your post title..." value="{{ old('title') }}">
                    @error('title')
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

                <input type="hidden" name="category_id" value="1">
            </div>
        </form>
    </div>
</div>
</div>

<script>
document.getElementById('imageInput1').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('imagePreview1').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

@if (session('open_modal'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalId = @json(session('open_modal')); // セッションからモーダルIDを取得
            const modalElement = document.getElementById(modalId); // IDでモーダル要素を取得
            console.log(modalElement);
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement); // bootstrapモーダルインスタンスを作成
                modal.show(); // モーダルを表示
            }
        });
    </script>
@endif
