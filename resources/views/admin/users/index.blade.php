@extends('layouts.app')

@section('title', 'Admin:Users')

@section('content')
<div class="container">
    <!-- ヘッダーと検索機能 -->
    <div class="d-flex justify-content-between align-items-center bg-secondary text-white p-3 rounded-top">
        <h2>User lists</h2>
    </div>

    <!-- ユーザーテーブル（テストデータをweb.phpに入れてます） -->
    <div class="bg-light p-3 border rounded-bottom">
        <table class="table table-hover align-middle bg-white border text-secondary">
            <thead class="small bg-info text-white">
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Created at</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                    class="img-thumbnail rounded-circle d-block mx-auto avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-sm"></i>
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            @if (!$user->is_active)
                                <i class="fa-solid fa-circle text-secondary"></i> &nbsp;Inactive
                            @else
                                <i class="fa-solid fa-circle text-success"></i> &nbsp;Active
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ページネーションまだ仮です -->
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#">&laquo;</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">9</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">10</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endsection
