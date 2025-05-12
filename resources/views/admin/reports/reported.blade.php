@extends('layouts.app')

@section('title', 'Admin: Reported Posts')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="fa-solid fa-flag text-danger me-2"></i>Reported Posts</h4>

    @forelse($reportedPosts as $post)
        {{-- @include('posts.components.post-card', ['post' => $post]) --}}
    @empty
        <p>No reported posts found.</p>
    @endforelse
</div>
@endsection
