@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')
<div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded-top">
        <h4 class="mb-0"><i class="fa-solid fa-users"></i> User Management</h4>
    </div>

    <!-- User Table -->
    <div class="bg-white p-3 border rounded-bottom table-responsive">
        <table class="table table-hover align-middle text-secondary">
            <thead class="table-info text-dark">
                <tr>
                    <th>#ID</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="text-center">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user fa-2x text-muted"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('profile.index', $user->id) }}" class="text-decoration-none">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role_id == \App\Models\User::ADMIN_ROLE_ID)
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if ($user->trashed())
                                <span class="text-muted"><i class="fa-solid fa-circle"></i> Inactive</span>
                            @else
                                <span class="text-success"><i class="fa-solid fa-circle"></i> Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->role_id !== \App\Models\User::ADMIN_ROLE_ID)
                                @if ($user->trashed())
                                    {{-- Activate --}}
                                    <form action="{{ route('admin.users.activate', ['user' => $user->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-user-check"></i> Activate
                                        </button>
                                    </form>
                                @else
                                    {{-- Deactivate --}}
                                    <form action="{{ route('admin.users.deactivate', ['user' => $user->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-user-slash"></i> Deactivate
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span class="text-muted small">Admin actions disabled</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center my-pagination">
            {{ $all_users->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
