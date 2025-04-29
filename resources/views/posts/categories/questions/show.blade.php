@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="row">
    {{-- メインコンテンツ --}}
    <div class="col-md-9">

  
    {{-- 質問カード --}}
    <div class="card w-100 shadow-sm mb-4">
      <div class="d-flex align-items-center border-bottom mb-2 p-2">
        <div class="rounded-circle" style="width: 40px; height: 40px; background-color: {{ $question->user->icon }}"></div>
        <strong class="mx-2">{{ $question->user->name }}</strong>
        <div class="ms-auto position-relative">
          <i class="fas fa-ellipsis-h" style="cursor:pointer;" data-bs-toggle="dropdown"></i>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-flag"></i> Report</a></li>
          </ul>
        </div>
      </div>

      <div class="card-body">
        <h5 class="fw-bold">{{ $question->title }}</h5>
        <p class="text-muted small">{{ $question->body }}</p>

        <div class="d-flex align-items-center mb-2">
          <div class="me-3 d-flex align-items-center">
            <i class="fa-regular fa-heart"></i><span class="ms-1">{{ $question->likes }}</span>
          </div>
          <div class="me-3">
            <i class="fa-regular fa-comment"></i><span class="ms-1">{{ $question->comments_count }}</span>
          </div>
        </div>

        <p class="text-uppercase text-muted small mb-0">Apr 28, 2025</p>
      </div>
    </div>

    {{-- 回答リスト --}}
    @foreach ($question->answers as $answer)
      <div class="card w-100 shadow-sm mb-3 position-relative">
        {{-- 回答ヘッダー --}}
        <div class="d-flex align-items-center border-bottom mb-2 p-2">
          <div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $answer->user->icon }}"></div>
          <strong class="mx-2">{{ $answer->user->name }}</strong>

          <div class="ms-auto">
            @if ($answer->is_best)
              <span class="badge bg-dark d-flex align-items-center">
                <i class="bi bi-check2-circle me-1"></i> Best Answer
              </span>
            @else
              {{-- Bestにするフォーム --}}
              <form action="{{ route('answers.best', ['answer' => $answer->id]) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-success">
                  <i class="bi bi-check2-circle"></i> Best
                </button>
              </form>
            @endif
          </div>
        </div>

        {{-- 回答本文 --}}
        <div class="card-body">
          <p class="text-muted small">{{ $answer->body }}</p>

          <div class="d-flex align-items-center text-muted small">
            <i class="fa-regular fa-heart"></i><span class="ms-1">{{ $answer->likes }}</span>
          </div>
        </div>
      </div>
    @endforeach

    </div>

    {{-- サイドバー --}}
    <div class="col-md-3 d-none d-md-block">
      @include('posts.components.sidebar-menu')
    </div>
  </div>
</div>
@endsection
