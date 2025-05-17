@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center align-items-start mt-3">
            <div class="col-8 col-md-9">
                <div id="post-list">
                    @forelse($all_posts as $post)
                        @if ($post)
                            @include('posts.components.post-card', ['post' => $post])
                        @endif
                    @empty
                        <p>No posts available.</p>
                    @endforelse
                </div>

            </div>

            <div class="col-md-3 d-none d-md-block ps-md-4 sidebar-sticky">
                @include('posts.components.sidebar-menu')
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center my-pagination post-pagination">
        {{ $all_posts->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

@endsection
