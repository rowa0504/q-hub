<!-- first form -->
<div class="modal fade" id="post-form">
    <div class="modal-dialog">
        <div class="modal-content border-info">
            <div class="modal-header border-info">
                <h3 class="h5 modal-title text-dark">
                    What category of information do you want to share?
                </h3>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    @csrf
                    @method('GET')

                    @foreach ($all_categories as $category)
                        <select name="" id="">
                            <option value="{{ $category->id }}"><button class="btn btn-info">{{ $category->name }}</button></option>
                        </select>
                    @endforeach

                    <button type="button" class="btn btn-outline-info btn-sm" data-bs-dismiss="modal">Cancel</button>
                </form>

                {{-- @if(request('')) --}}
            </div>
        </div>
    </div>
</div>
