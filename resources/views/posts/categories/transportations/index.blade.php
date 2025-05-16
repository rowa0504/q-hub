@extends('layouts.app')

@section('title', 'Transpotation')

@section('content')

{{-- 投稿表示 + PCメニュー --}}
<div class="container-fluid">
    <div class="row justify-content-center align-items-start mt-3">
        <div class="col-12 col-md-9">
            <!-- ステータスフィルター -->
            <div class="mb-3">
                <form method="GET" action="{{ route('transportation.index') }}">
                    @if (!empty($all_trans_categories))
                        <select name="trans_category_id" id="trans_category_id" class="form-select" onchange="this.form.submit()">
                            <option value="" selected>Select transportation</option>
                            @foreach ($all_trans_categories as $trans_category)
                                <option value="{{ $trans_category->id }}" {{ request('trans_category_id') == $trans_category->id ? 'selected' : '' }}>
                                    {{ $trans_category->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </form>
            </div>

            @forelse($all_posts as $post)
                @if (request('trans_category_id') == null || $post->trans_category_id == request('trans_category_id'))
                    @include('posts.components.post-card', ['post' => $post])
                @endif
            @empty
                <p>No posts available.</p>
            @endforelse
        </div>
        <div class="col-md-3 d-none d-md-block ps-md-4 sidebar-sticky">
            @include("posts.components.sidebar-menu")
        </div>
    </div>
</div>

@endsection
