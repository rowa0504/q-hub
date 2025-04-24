@extends('layouts.app')

@section('content')

{{-- ダミーデータ --}}
@php
$questions = [
    (object)[
        'id' => 1,
        'title' => 'How do I install Laravel?',
        'body' => 'I am new to Laravel. Can someone walk me through the installation steps on Windows? lorem300 ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'comments_count' => 2,
        'user' => (object)[ 'name' => 'Alice', 'icon' => '#f88' ]
    ],
    (object)[
        'id' => 2,
        'title' => 'What is MVC in Laravel?',
        'body' => 'I keep hearing about MVC. Can someone explain how it works in Laravel?lorem10000 ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'comments_count' => 5,
        'user' => (object)[ 'name' => 'Bob', 'icon' => '#8f8' ]
    ],
    (object)[
        'id' => 3,
        'title' => 'Laravel vs Symfony: Which to choose?',
        'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae aperiam consequuntur earum, placeat recusandae enim consectetur. Natus facere eius doloremque soluta, autem iure, earum atque ut beatae ea optio sed recusandae accusamus! Odio, tempora ex possimus cum aspernatur iste, quasi necessitatibus tempore maiores officiis nesciunt perspiciatis voluptatum ipsum nulla suscipit ut debitis consequatur saepe minima sunt rem, recusandae corrupti assumenda hic. Ex corrupti porro cumque temporibus, reiciendis veritatis quis deserunt dignissimos. Ex enim ipsa assumenda praesentium ratione tempora perspiciatis quas laudantium consectetur modi? Provident dolores tempora cumque dignissimos ab fuga culpa nulla numquam architecto aspernatur sint quaerat libero cupiditate molestias unde itaque adipisci consequatur minima, similique atque ipsam! Autem, at non accusamus incidunt enim earum soluta inventore asperiores esse consectetur nobis, libero, nostrum hic voluptatum quae eaque. In asperiores quasi molestias et voluptatibus velit modi facilis id quos autem, numquam exercitationem optio quod sapiente, iste eaque ipsa est esse quae porro? Ipsa, rerum vel dolores autem itaque architecto optio incidunt quisquam natus voluptates ex voluptatibus delectus enim debitis. Unde aut iure debitis magnam ratione cum numquam sunt id? Aliquam doloribus sequi dicta quaerat, ab porro obcaecati perspiciatis reprehenderit. Vitae impedit deserunt omnis? Optio, facere veritatis eligendi illo ipsa, labore consequuntur repellendus repudiandae maiores quam odio dignissimos asperiores nisi necessitatibus et ab voluptatibus animi iste ipsum architecto molestiae, harum quas? Excepturi voluptate illo reprehenderit nam eos rerum laborum, nisi consectetur quasi optio vitae eaque nihil quam eligendi in facilis ducimus. Dolore eos corrupti ea quod. Laudantium, suscipit eius. Exercitationem quas necessitatibus voluptatem voluptate minus possimus deleniti eligendi voluptatibus porro eveniet explicabo aliquid corrupti officia quo fuga autem sint dicta, cum ipsam id quam deserunt nostrum pariatur. Totam ex ducimus dolor ab odio voluptatibus earum soluta. Quasi laudantium a, molestiae perferendis ut commodi natus nulla veniam, qui obcaecati rerum provident, earum porro?I’m trying to pick a PHP framework. Why should I choose Laravel over Symfony?lorem300',
        'comments_count' => 3,
        'user' => (object)[ 'name' => 'Charlie', 'icon' => '#88f' ]
    ],
    (object)[
        'id' => 4,
        'title' => 'How to use Eloquent relationships?',
        'body' => 'I want to understand hasMany and belongsTo in Laravel. Any simple examples?',
        'comments_count' => 4,
        'user' => (object)[ 'name' => 'Diana', 'icon' => '#ff8' ]
    ],
    (object)[
        'id' => 5,
        'title' => 'What is Laravel Mix?',
        'body' => 'I heard Laravel Mix helps with compiling assets. How do I get started with it?',
        'comments_count' => 1,
        'user' => (object)[ 'name' => 'Ethan', 'icon' => '#8ff' ]
    ],
    (object)[
        'id' => 6,
        'title' => 'Blade templating tips?',
        'body' => 'What are some best practices when writing Blade templates in Laravel?',
        'comments_count' => 6,
        'user' => (object)[ 'name' => 'Fiona', 'icon' => '#f8f' ]
    ],
    (object)[
        'id' => 7,
        'title' => 'Laravel Auth customization',
        'body' => 'How do I customize the default Laravel login and register forms?',
        'comments_count' => 2,
        'user' => (object)[ 'name' => 'George', 'icon' => '#faa' ]
    ],
    (object)[
        'id' => 8,
        'title' => 'Using API routes in Laravel',
        'body' => 'I’m building a mobile app. How can I create RESTful APIs using Laravel?',
        'comments_count' => 3,
        'user' => (object)[ 'name' => 'Hannah', 'icon' => '#afa' ]
    ],
    (object)[
        'id' => 9,
        'title' => 'Laravel error: Target class does not exist',
        'body' => 'I keep getting this error when routing. What could be the reason?',
        'comments_count' => 7,
        'user' => (object)[ 'name' => 'Ian', 'icon' => '#aaf' ]
    ],
    (object)[
        'id' => 10,
        'title' => 'Deploying Laravel to Heroku',
        'body' => 'Is there a guide or tips for deploying Laravel apps to Heroku?',
        'comments_count' => 4,
        'user' => (object)[ 'name' => 'Jane', 'icon' => '#ffa' ]
    ],
];
@endphp
{{-- ダミーデータここまで --}}


<div class="container py-3">
    <div class="container py-3">
        {{-- 質問追加ボタン --}}
        <div class="mb-4 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                Add Question
            </button>
        </div>
        {{-- モーダルファイルを読み込み --}}
        @include('questions.modal.add_questions')
    </div>
    @foreach ($questions as $question)
    <div class="card mb-3 shadow-sm border border-dark">
        <div class="card-body d-flex">
            {{-- アイコン --}}
            <div class="me-3">
                <div class="rounded-circle" style="width: 40px; height: 40px; background-color: {{ $question->user->icon }}"></div>
            </div>

            {{-- 本文 --}}
            <div class="flex-grow-1">
                <strong>{{ $question->user->name }}</strong>
                <h5 class="mt-1">
                    <a href="/questions/{{ $question->id }}" class="text-decoration-none text-dark">
                      {{ $question->title }}
                    </a>
                </h5>

                {{-- 本文の長さをスマホ/PCで切り替え --}}
                <p class="text-muted small d-block d-sm-none">
                    {{ \Illuminate\Support\Str::limit($question->body, 100) }}
                </p>
                <p class="text-muted small d-none d-sm-block">
                    {{ $question->body }}
                </p>

                {{-- アイコン群 --}}
                <div class="d-flex justify-content-between align-items-center mt-2 text-muted">
                    <div>
                        <i class="bi bi-chat-left-text me-2"></i>{{ $question->comments_count }}
                        <i class="bi bi-heart ms-3 me-2"></i>0
                    </div>
                    <i class="bi bi-three-dots"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
