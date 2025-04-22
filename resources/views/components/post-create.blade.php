@extends('layouts.app')

@section('content')
    <h1>投稿作成</h1>

    {{-- モーダルの背景 --}}
    @if ($categoryId)
        <div class="modal-backdrop fade show"></div>
    @endif

    {{-- カテゴリIDによってモーダルを分ける --}}
    @if ($categoryId == 7)
        @include('components.post-form-other-modal')
    @endif
@endsection
