@extends('layouts.app')

@section('title', 'Item')

@section('content')

    {{-- 投稿表示 + PCメニュー --}}
    <div class="container-fluid">
        <div class="row justify-content-center align-items-start mt-3">
            <div class="col-12 col-md-9">

                <div class="max-w-xl mx-auto mt-5">
                    <h2 class="text-2xl font-bold mb-4">What kind of item do you want?</h2>

                    {{-- 検索フォーム --}}
                    <form action="{{ route('item.search') }}" method="GET"
                        class="d-flex mb-3 bg-white rounded-pill p-2 shadow-sm">
                        <input type="text" placeholder="Search your item..." class="form-control border-0 me-2"
                            name="search" id="search" aria-label="Search for items">
                        <button class="btn btn-info text-white rounded-circle" type="submit" aria-label="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    {{-- 成功メッセージ --}}
                    @if (session('success'))
                        <div class="alert alert-success p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 新規アイテム登録フォーム --}}
                    <form action="{{ route('wantedItem.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="keyword" class="form-label text-sm font-medium text-gray-700">Item Name</label>
                            <input type="text" name="keyword" id="keyword" class="form-control mb-1" required>
                            @error('keyword')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-info px-4 py-2 rounded">
                            Register
                        </button>
                    </form>
                </div>

                {{-- 投稿表示 --}}
                <div class="mt-5">
                    @forelse($all_posts as $post)
                        @include('posts.components.post-card', ['post' => $post])
                    @empty
                        <p>No posts available.</p>
                    @endforelse
                </div>
            </div>

            {{-- サイドメニュー --}}
            <div class="col-md-3 d-none d-md-block ps-md-4 sidebar-sticky">
                @include('posts.components.sidebar-menu')
            </div>
        </div>
    </div>

@endsection
