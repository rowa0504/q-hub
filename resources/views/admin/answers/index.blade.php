@extends('layouts.app')

@section('title', 'Admin: Answers')

@section('content')
<div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded-top">
        <h4 class="mb-0"><i class="fa-solid fa-reply"></i> Answer Management</h4>
    </div>

    <!-- Answer Table -->
    <div class="bg-white p-3 border rounded-bottom table-responsive">
        <table class="table table-hover align-middle text-secondary">
            <thead class="table-info text-dark">
                <tr>
                    <th>#ID</th>
                    <th>Answer</th>
                    <th>User</th>
                    <th>Post</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_answers as $answer)
                    <tr>
                        <td>{{ $answer->id }}</td>
                        <td>{{ Str::limit($answer->body, 50) }}</td>
                        <td>
                            @if ($answer->user)
                                <a href="{{ route('profile.index', $answer->user->id) }}" class="text-decoration-none text-dark">
                                    {{ $answer->user->name }}
                                </a>
                            @else
                                <span class="text-muted">[Unknown]</span>
                            @endif
                        </td>
                        <td>
                            @if ($answer->post)
                                <a href="{{ $answer->post->getCategoryRoute() }}" class="text-decoration-none">
                                    {{ $answer->post->title ?? 'Post #' . $answer->post_id }}
                                </a>
                            @else
                                <span class="text-muted">[Deleted Post]</span>
                            @endif
                        </td>
                        <td>{{ $answer->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if ($answer->deleted_at)
                                <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                            @else
                                <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($answer->deleted_at)
                                <form action="{{ route('admin.answers.activate', $answer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-rotate-left"></i> Restore
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.answers.deactivate', $answer->id) }}" method="POST" class="d-inline">
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
                        <td colspan="7" class="text-center text-muted">No answers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center my-pagination">
            {{ $all_answers->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
