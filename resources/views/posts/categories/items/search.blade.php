@extends('layouts.app')

@section('title', 'Item')

@section('content')

    {{-- 投稿表示 + PCメニュー --}}
    <div class="container-fluid">
        <div class="row justify-content-center align-items-start mt-3">
            <div class="col-12 col-md-9">
                <form action="{{ route('item.search') }}" class="search-box mb-3 d-flex bg-white rounded-pill px-3 py-2">
                    <input type="text" placeholder="Search ..." class="form-control border-2 me-2" name="search"
                        id="search">
                    <button class="btn btn-info text-white rounded-circle">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <p class="h5 text-muted mb-4">Search results for "<span class="fw-bold">{{ $search }}</span>"</p>
                @forelse($posts as $post)
                    @include('posts.components.post-card', ['post' => $post])
                @empty
                    <p>No items found.</p>
                @endforelse
            </div>
            <div class="col-md-3 d-none d-md-block ps-md-4 sidebar-sticky">
                @include('posts.components.sidebar-menu')
            </div>
        </div>
    </div>

    {{-- pagination --}}
    <div class="d-flex justify-content-center my-pagination post-pagination">
        {{ $all_posts->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

@endsection
