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
            'image_url' => 'https://placehold.co/1000x600',
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

                {{-- モーダル --}}
                @include('posts.categories.questions.modal.add_questions')

                        {{-- 本文 --}}
                        <div class="flex-grow-1">
                            <strong>{{ $question->user->name }}</strong>
                            <h5 class="mt-1">
                                <a href="/questions/{{ $question->id }}" class="text-decoration-none text-dark">
                                    {{ $question->title }}
                                </a>
                            </h5>

                            <div class="flex-grow-1">
                                <strong>{{ $question->user->name }}</strong>
                                <h5 class="mt-1">
                                    <a href="/questions/{{ $question->id }}" class="text-decoration-none text-dark">
                                        {{ $question->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small d-block d-sm-none">
                                    {{ \Illuminate\Support\Str::limit($question->body, 100) }}
                                </p>
                                <p class="text-muted small d-none d-sm-block">
                                    {{ $question->body }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-2 text-muted">
                                    <div>
                                        <i class="bi bi-chat-left-text me-2"></i>{{ $question->comments_count }}
                                        <i class="bi bi-heart ms-3 me-2"></i>0
                                    </div>
                                    <i class="bi bi-three-dots"></i>
                                    {{-- modal --}}
                                    @include('posts.components.modals.delete-modal', ['post' => $post])
                                    @include('posts.components.modals.edit-modal', ['post' => $post])
                                    @include('posts.components.modals.report-modal', ['post' => $post])
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
