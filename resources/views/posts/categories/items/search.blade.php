@extends('layouts.app')

@section('title', 'Item')

@section('content')

    {{-- 投稿表示 + PCメニュー --}}
    <div class="container-fluid">
        <div class="row justify-content-center align-items-start mt-3">
            <div class="col-12 col-md-9">

                <div class="max-w-xl mx-auto mt-5">

                    {{-- 成功メッセージ --}}
                    @if (session('success'))
                        <div class="alert alert-success p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    {{-- 新規アイテム登録フォーム --}}
                    <form action="{{ route('wantedItem.store') }}" method="POST" class="row g-3 align-items-end mt-4">
                        @csrf

                        {{-- ラベルと入力欄 --}}
                        <div class="col-md-9">
                            <label for="keyword" class="form-label fw-semibold">Item Name</label>
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                placeholder="Enter item name" required>
                            @error('keyword')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 登録ボタン --}}
                        <div class="col-md-3">
                            <label class="form-label invisible">Register</label> {{-- invisibleで上下位置調整 --}}
                            <button type="submit" class="btn btn-info w-100 fw-bold">
                                Register
                            </button>
                        </div>
                    </form>

                </div>

                <p class="h5 text-muted mb-4">Search results for "<span class="fw-bold">{{ $search }}</span>"</p>
                @forelse($posts as $post)
                    @include('posts.components.post-card', ['post' => $post])
                @empty
                    <p>No items found.</p>
                @endforelse
            </div>
            <div class="col-md-3 d-none d-md-block ps-md-4 sidebar-sticky">
                @include('posts.components.sidebar-menu')
            </div>
        </div>
    </div>

    {{-- pagination --}}
    <div class="d-flex justify-content-center w-100 post-pagination my-pagination">
        {{ $posts->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

@endsection
