<!-- Category Selection Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <h5 class="modal-title text-center mb-3">What would you like to share?</h5>
            <div class="d-grid gap-2">
                @if (!empty($all_categories))
                    @foreach ($all_categories as $category)
                        <button class="btn btn-info text-white text-capitalize" data-bs-toggle="modal" data-bs-target="#post-form-{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                @endif
                <button class="btn btn-outline-info" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
