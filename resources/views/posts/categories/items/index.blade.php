@extends('layouts.app')

@section('title', 'Item')

@section('content')

{{-- 投稿表示 + PCメニュー --}}
<div class="container-fluid">
    <div class="row justify-content-center align-items-start mt-3">
        <div class="col-12 col-md-9">
            <form  action="{{ route('item.search') }}" class="search-box mb-3 d-flex bg-white rounded-pill px-3 py-2">
                <input type="text" placeholder="Search ..." class="form-control border-2 me-2" name="search" id="search">
                <button class="btn btn-info text-white rounded-circle">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="max-w-xl mx-auto mt-10">
                <h2 class="text-2xl font-bold mb-4">What kind of item do you want?</h2>

                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('wantedItem.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input type="text" name="keyword" id="keyword" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('keyword')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        register
                    </button>
                </form>
            </div>
            @forelse($all_posts as $post)
                @include('posts.components.post-card', ['post' => $post])
            @empty
                <p>No posts available.</p>
            @endforelse
        </div>
        <div class="col-md-3 d-none d-md-block ps-md-4">
            @include("posts.components.sidebar-menu")
        </div>
    </div>
</div>

@endsection
