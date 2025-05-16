@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
<div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded-top">
        <h4 class="mb-0"><i class="fa-solid fa-newspaper"></i> Post Management</h4>
    </div>

    <!-- Post Table -->
    <div class="bg-white p-3 border rounded-bottom table-responsive">
        <table class="table table-hover align-middle text-secondary">
            <thead class="table-info text-dark">
                <tr>
                    <th>#ID</th>
                    <th>Title</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            @if ($post->getCategoryRoute())
                                <a href="{{ $post->getCategoryRoute() }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            @else
                                <span class="text-muted">No route</span>
                            @endif
                        </td>

                        <td>
                            @if ($post->user)
                                {{ $post->user->name }}
                            @else
                                <span class="text-muted">[Unknown]</span>
                            @endif
                        </td>

                        <td>{{ $post->category->name ?? 'N/A' }}</td>
                        <td>{{ $post->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if ($post->deleted_at)
                                <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                            @else
                                <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($post->deleted_at)
                                <form action="{{ route('admin.posts.activate', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-rotate-left"></i> Restore
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.posts.deactivate', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center my-pagination">
            {{ $all_posts->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
