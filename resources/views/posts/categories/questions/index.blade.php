@extends('layouts.app')

@section('content')
@php
    $questions = [
        (object)[
            'id' => 1,
            'title' => 'How do I install Laravel?',
            'body' => 'I am new to Laravel. Can someone walk me through the installation steps on Windows? Lorem ipsum dolor sit amet.',
            'image_url' => null,
            'comments_count' => 2,
            'user' => (object)['name' => 'Alice', 'icon' => '#f88'],
        ],
        (object)[
            'id' => 2,
            'title' => 'Laravel vs Symfony: Which to choose?',
            'body' => 'Trying to pick a PHP framework. Why should I choose Laravel over Symfony? Lorem ipsum dolor sit amet.',
            'image_url' => 'https://placehold.co/600x400',
            'comments_count' => 3,
            'user' => (object)['name' => 'Charlie', 'icon' => '#88f'],
        ],
    ];
@endphp

<div class="container-fluid py-4">
    <div class="row">
        {{-- メインコンテンツ --}}
        <div class="col-md-9">
            {{-- 質問追加ボタン --}}
            <div class="mb-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                    Add Question
                </button>
            </div>

            {{-- モーダル --}}
            @include('posts.categories.questions.modal.add_questions')

            {{-- 質問リスト --}}
            @foreach ($questions as $question)
                <div class="card mb-3 shadow-sm border border-dark">
                    <div class="card-body d-flex">
                        {{-- ユーザーアイコン --}}
                        <div class="me-3">
                            <div class="rounded-circle" style="width: 40px; height: 40px; background-color: {{ $question->user->icon }}"></div>
                        </div>

                        {{-- 本文 --}}
                        <div class="flex-grow-1">
                            <strong>{{ $question->user->name }}</strong>
                            <h5 class="mt-1">
                                <a href="{{ route('posts.categories.questions.show', $question->id) }}" class="text-decoration-none text-dark">
                                    {{ $question->title }}
                                </a>
                            </h5>

                            {{-- 画像がある場合 --}}
                            @if ($question->image_url)
                                <div class="my-2">
                                    <img src="{{ $question->image_url }}" alt="Post Image" class="img-fluid rounded">
                                </div>
                            @endif

                            {{-- 質問本文 --}}
                            <p class="text-muted small mt-2">
                                {{ \Illuminate\Support\Str::limit($question->body, 150) }}
                            </p>

                            {{-- コメント数・いいね数 --}}
                            <div class="d-flex justify-content-between align-items-center text-muted small mt-2">
                                <div>
                                    <i class="bi bi-chat-left-text me-1"></i>{{ $question->comments_count }}
                                    <i class="bi bi-heart ms-3 me-1"></i>0
                                </div>
                                <i class="bi bi-three-dots"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- サイドバー（右） --}}
        <div class="col-md-3 d-none d-md-block">
            @include('posts.components.sidebar-menu')
        </div>
    </div>
</div>
@endsection
