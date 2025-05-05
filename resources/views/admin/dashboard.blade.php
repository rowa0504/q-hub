@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- カード表示（統計） --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-users fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Users</h5>
                    <p class="h4">{{ $user_count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-newspaper fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Posts</h5>
                    <p class="h4">{{ $post_count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-comments fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Comments</h5>
                    <p class="h4">{{ $comments_count }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Recent Users</h5>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recent_users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->trashed())
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
