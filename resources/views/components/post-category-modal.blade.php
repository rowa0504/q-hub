<!-- Category Selection Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <h5 class="modal-title text-center mb-3">What category of information do you want to share?</h5>
            <div class="d-grid gap-2">
                @foreach ($all_categories as $category)
                    <button class="btn btn-info text-white text-capitalize" data-bs-toggle="modal" data-bs-target="#post-form-{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
                {{-- @foreach (['event', 'food', 'item', 'travel', 'transportation', 'question', 'other'] as $category)
                    @switch($category)
                        @case('other')
                            <a href="#" class="btn btn-info text-white text-capitalize" data-bs-dismiss="modal"
                                data-bs-toggle="modal" data-bs-target="#otherPostModal">
                                {{ $category }}
                            </a>
                        @break

                        @default
                            <a href="#" class="btn btn-info text-white text-capitalize">
                                {{ $category }}
                            </a>
                    @endswitch
                @endforeach --}}
                <button class="btn btn-outline-info" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
