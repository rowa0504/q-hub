@extends('layouts.app')

@section('title', 'Admin: Comments')

@section('content')
<div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded-top">
        <h4 class="mb-0"><i class="fa-regular fa-comments"></i> Comment Management</h4>
    </div>

    <!-- Comment Table -->
    <div class="bg-white p-3 border rounded-bottom table-responsive">
        <table class="table table-hover align-middle text-secondary">
            <thead class="table-info text-dark">
                <tr>
                    <th>#ID</th>
                    <th>Comment</th>
                    <th>User</th>
                    <th>Post</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ Str::limit($comment->body, 50) }}</td>
                        <td>
                            @if ($comment->user)
                                <a href="{{ route('profile.index', $comment->user->id) }}" class="text-decoration-none text-dark">
                                    {{ $comment->user->name }}
                                </a>
                            @else
                                <span class="text-muted">[Unknown]</span>
                            @endif
                        </td>
                        <td>
                            @if ($comment->post)
                                <a href="{{ $comment->post->getCategoryRoute() }}" class="text-decoration-none">
                                    {{ $comment->post->title ?? 'Post #' . $comment->post_id }}
                                </a>
                            @else
                                <span class="text-muted">[Deleted Post]</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if ($comment->deleted_at)
                                <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                            @else
                                <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($comment->deleted_at)
                                <form action="{{ route('admin.comments.activate', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-rotate-left"></i> Restore
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.comments.deactivate', $comment->id) }}" method="POST" class="d-inline">
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
                        <td colspan="7" class="text-center text-muted">No comments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center my-pagination">
            {{ $all_comments->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
