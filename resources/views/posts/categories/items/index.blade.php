@extends('layouts.app')

@section('title', 'Item')

@section('content')

    {{-- 投稿表示 + PCメニュー --}}
    <div class="container-fluid">
        <div class="row justify-content-center align-items-start mt-3">
            <div class="col-12 col-md-9">

                <div class="max-w-xl mx-auto mt-2">

                    {{-- 成功メッセージ --}}
                    {{-- @if (session('itemSuccess'))
                        <div id="successItemMessage" class="alert alert-success p-3 rounded mb-4">
                            {{ session('itemSuccess') }}
                        </div>

                        <script>
                        setTimeout(() => {
                            const msg = document.getElementById('successItemMessage');
                            if (msg) {
                                msg.style.opacity = '0';
                                setTimeout(() => msg.remove(), 1000); // 完全に削除
                            }
                        }, 2000); // 3秒後にフェードアウト開始
                        </script>
                    @endif --}}
                    {{-- 新規アイテム登録フォーム --}}
                    <form action="{{ route('wantedItem.store') }}" method="POST" class="row g-3 align-items-end mt-2">
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

    {{-- pagination --}}
    <div class="d-flex justify-content-center w-100 post-pagination my-pagination">
        {{ $all_posts->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

@endsection
