<div class="modal fade" id="edit-form-{{ $post->id }}" data-post-id="{{ $post->id }}" tabindex="-1" aria-labelledby="otherPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            {{-- masa->bodyのみ別ファイルで挿入（categoryごとに分ける必要があるため） --}}
            @if ($post->category_id == 1)
                @include('posts.components.edit-forms.modal-bodys.event', ['post' => $post])
            @elseif ($post->category_id == 2)
                @include('posts.components.edit-forms.modal-bodys.food', ['post' => $post])
            @elseif ($post->category_id == 3)
                @include('posts.components.edit-forms.modal-bodys.item', ['post' => $post])
            @elseif ($post->category_id == 4)
                @include('posts.components.edit-forms.modal-bodys.travel', ['post' => $post])
            @elseif ($post->category_id == 5)
                @include('posts.components.edit-forms.modal-bodys.transportation', ['post' => $post])
            @elseif ($post->category_id == 6)
                @include('posts.components.edit-forms.modal-bodys.question', ['post' => $post])
            @elseif ($post->category_id == 7)
                @include('posts.components.edit-forms.modal-bodys.other', ['post' => $post])
            @endif
        </div>
    </div>
</div>
