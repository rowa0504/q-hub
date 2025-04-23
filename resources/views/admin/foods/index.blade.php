@extends('layouts.app')

@section('title', 'Admin:Foods')

{{-- ▼▼▼ テストデータ（Blade内に直接定義） ▼▼▼ --}}
@php
    $all_foods = [
        (object)[
            'id' => 1,
            'image' => null,
            'name' => 'Fried Chicken',
            'category' => 'Main Dish',
            'calories' => 350,
            'created_at' => now()->subDays(1),
        ],
        (object)[
            'id' => 2,
            'image' => null,
            'name' => 'Green Salad',
            'category' => 'Vegetable',
            'calories' => 80,
            'created_at' => now()->subDays(2),
        ],
        (object)[
            'id' => 3,
            'image' => null,
            'name' => 'Spaghetti Carbonara',
            'category' => 'Pasta',
            'calories' => 500,
            'created_at' => now()->subDays(3),
        ],
    ];
    
    Route::get('/admin/foods', function () {return view('admin.foods.index');});
@endphp
{{-- 🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼テストデータ終了🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼🔼 --}}


@section('content')
<div class="container">
    <!-- ヘッダー -->
    <div class="d-flex justify-content-between align-items-center bg-secondary text-white p-3 rounded-top">
        <h2>Food lists</h2>
    </div>

    <!-- フードテーブル -->
    <div class="bg-light p-3 border rounded-bottom">
        <table class="table table-hover align-middle bg-white border text-secondary">
            <thead class="small bg-info text-white">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Calories</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($all_foods))
                @foreach ($all_foods as $food)
                    <tr>
                        <td>{{ $food->id }}</td>
                        <td>
                            @if ($food->image)
                                <img src="{{ $food->image }}" alt="{{ $food->name }}"
                                     class="img-thumbnail rounded-circle d-block mx-auto avatar-sm">
                            @else
                                <i class="fa-solid fa-utensils text-secondary d-block text-center icon-sm"></i>
                            @endif
                        </td>
                        <td>{{ $food->name }}</td>
                        <td>{{ $food->category }}</td>
                        <td>{{ $food->calories }} kcal</td>
                        <td>{{ $food->created_at }}</td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- ページネーション（仮） -->
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
