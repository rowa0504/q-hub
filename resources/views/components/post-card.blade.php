<div class="card w-100">
    {{-- 投稿の詳細モーダル --}}
    <div class="d-flex align-items-center border-bottom">
      <img src="{{ $post->user->avatar ?? '' }}" class="rounded-circle me-2 avatar-sm" alt="Profile">
      <strong>{{ $post->user->name }}</strong>
      <div class="ms-auto">
        <i class="fas fa-ellipsis-h"></i>
      </div>
    </div>

    <div class="container p-0">
      <a href="#">
        <img src="{{ $post->image_url }}" class="w-100" alt="Post Image">
      </a>
    </div>

    <div class="card-body">
      <div class="row align-items-center flex-wrap">
        <div class="col-auto d-flex align-items-center gap-2">
          <!-- Likeボタン -->
          <form action="#" method="post">
            @csrf
            <button class="btn btn-sm shadow-none p-0">
              {{-- @if($post->likedBy(Auth::user())) --}}
                <i class="fa-solid fa-heart fa-lg text-danger"></i>
              {{-- @else --}}
                {{-- <i class="fa-regular fa-heart fa-lg"></i>
              @endif --}}
            </button>
          </form>

          <!-- Like数 -->
          <span data-bs-toggle="modal" data-bs-target="#likedUsersModal-{{ $post->id }}" class="text-danger me-2" style="cursor:pointer;">
            {{-- {{ $post->likes_count }} --}}
          </span>

          <!-- コメントアイコン＋数 -->
          <span data-bs-toggle="modal" data-bs-target="#commentsModal-{{ $post->id }}" style="cursor:pointer;">
            <i class="fa-regular fa-comment fa-lg"></i>
            {{-- {{ $post->comments_count }} --}}
          </span>
        </div>

        <div class="col text-end">
          <span class="badge bg-secondary bg-opacity-50">{{ $post->category->name ?? 'Uncategorized' }}</span>
        </div>
      </div>

      <a href="#" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
      &nbsp;
      <p class="d-inline fw-light">
        {{-- {{ $post->caption }}</p> --}}
      <p class="text-uppercase text-muted small">{{ $post->created_at->format('M d, Y') }}</p>
    </div>
  </div>
