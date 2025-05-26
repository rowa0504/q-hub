@extends('layouts.app')

@section('title', 'Transportation Search')

@section('content')

    {{-- 検索結果表示 + PCメニュー --}}
    <div class="container-fluid">
        <div class="row justify-content-center align-items-start mt-3">
            <div class="col-12 col-md-9">

                <!-- ステータスフィルター -->
                <div class="mb-3">
                    <form method="GET" action="{{ route('transportation.index') }}">
                        @if (!empty($all_trans_categories))
                            <select name="trans_category_id" id="trans_category_id" class="form-select"
                                onchange="this.form.submit()">
                                <option value="" selected>Select transportation</option>
                                @foreach ($all_trans_categories as $trans_category)
                                    <option value="{{ $trans_category->id }}"
                                        {{ request('trans_category_id') == $trans_category->id ? 'selected' : '' }}>
                                        {{ $trans_category->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </form>
                </div>

                <h5 class="mb-4 text-muted">Search results for "<strong>{{ $search }}</strong>"</h5>

                @forelse($posts as $post)
                    @include('posts.components.post-card', ['post' => $post])
                @empty
                    <p>No matching transportation posts found.</p>
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
