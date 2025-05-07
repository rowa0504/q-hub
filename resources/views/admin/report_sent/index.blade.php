@extends('layouts.app')

@section('title', 'Warned Posts')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="fa-solid fa-envelope-circle-check me-2"></i>Warned Posts</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Warned At</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($warned_posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->user->name ?? 'Unknown' }}</td>
                        <td>{{ $post->category->name ?? 'N/A' }}</td>
                        <td>{{ $post->updated_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($post->getCategoryRoute())
                                <a href="{{ $post->getCategoryRoute() }}" class="btn btn-sm btn-outline-primary" target="_blank">View</a>
                            @else
                                <span class="text-muted">No route</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">No warned posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
