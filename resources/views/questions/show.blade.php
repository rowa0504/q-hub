@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="row">
    {{-- メインコンテンツ：左側（col-md-9） --}}
    <div class="col-md-9">

   {{-- ダミーデータ --}}
  @php
  $question = (object)[
    'title' => 'LaravelでSeederってどう使うの？',
    'body' => 'Seederの使い方がよく分かりません。どのタイミングで使えばいいですかLorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur veniam, voluptates architecto ut veritatis optio eligendi qui reiciendis quod numquam, delectus expedita dolores commodi quibusdam explicabo ipsam. Ipsum debitis, impedit, quos ut quisquam natus iure perferendis voluptatibus qui aut voluptate, molestiae tempore deleniti sint doloribus illum quaerat optio accusantium! Labore explicabo debitis laboriosam dolor numquam molestiae reiciendis perferendis fuga excepturi quia odio quaerat ullam quae soluta nisi et quos, quis assumenda placeat officia iusto voluptatem natus ex dolorem? Perferendis vel consequuntur exercitationem, debitis eveniet magnam cum mollitia quibusdam veniam repellendus ea provident et totam laboriosam, nobis fuga ex, sapiente quisquam tempora optio accusantium. Quia expedita suscipit tempore et vitae corrupti omnis nulla tenetur iure nihil voluptatibus corporis, totam perspiciatis quas! Non, distinctio consequatur quos nam ipsa cumque omnis doloremque corporis quam tempore eveniet veritatis fugit! Reiciendis assumenda expedita necessitatibus dignissimos est quibusdam dolores voluptatum animi, sunt porro dolorem fuga illum. Accusamus vitae nisi, et quae doloremque molestias? Dicta laudantium molestiae laborum dolor, libero, non autem eius inventore possimus magnam est vero accusamus sint officiis a sit ad repellat alias, quo odit? Culpa voluptatum a, maiores nihil laudantium eligendi? Quibusdam, error! Iure inventore voluptas vero, ex eum aut quaerat. Nostrum eius quia tempora. Quo molestiae nam mollitia? Quaerat dolor similique soluta ratione quasi quis natus tempora deserunt quidem reiciendis. Error, minus nemo et asperiores labore cumque atque veniam maxime unde, architecto cupiditate ab rerum, vitae dignissimos quasi non consequatur qui iure rem? Porro, ipsa velit? Laborum beatae tempore perspiciatis nostrum tenetur inventore expedita ratione vero. Facere assumenda vitae sed architecto. Nobis numquam corrupti aliquam, nihil, reprehenderit praesentium error esse, vel sed excepturi saepe inventore magni animi qui! Ipsum voluptas eos, atque ex nemo amet accusamus vero consectetur totam iste quidem eligendi repudiandae architecto veniam. Illum laborum explicabo velit saepe expedita doloremque.？',
    'comments_count' => 2,
    'likes' => 99,
    'user' => (object)[
      'name' => 'Test User',
      'icon' => '#ff6347',
    ],

    'answers' => [
      (object)[
        'body' => 'Seederはテストデータを入れるために使うよ！',
        'likes' => 5,
        'is_best' => true,
        'user' => (object)[
          'name' => 'Answer Guy',
          'icon' => '#4682b4',
        ]
      ],
      (object)[
        'body' => 'DatabaseSeeder.php にまとめると便利だよ！',
        'likes' => 3,
        'is_best' => false,
        'user' => (object)[
          'name' => 'Helper',
          'icon' => '#32cd32',
        ]
      ],
    ]
  ];
@endphp

      {{-- 質問カード --}}
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="rounded-circle me-2 flex-shrink-0" style="width: 40px; height: 40px; background-color: {{ $question->user->icon }}"></div>
            <strong>{{ $question->user->name }}</strong>
          </div>
          <h5 class="fw-bold">{{ $question->title }}</h5>
          <p class="text-muted">{{ $question->body }}</p>
          <div class="d-flex justify-content-between text-muted small">
            <div>
              <i class="bi bi-chat-left-text me-2"></i>{{ $question->comments_count }}
              <i class="bi bi-heart"></i> {{ $question->likes }}
            </div>
            <i class="bi bi-three-dots"></i>
          </div>
        </div>
      </div>

      {{-- モーダルトリガーボタン --}}
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#answerModal">
        <i class="bi bi-pencil-square me-1"></i> Answer
      </button>

      {{-- モーダル読み込み --}}
      @include('questions.modal.answer')

      {{-- 回答一覧 --}}
      @foreach ($question->answers as $answer)
        <div class="card mb-3 shadow-sm position-relative">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="rounded-circle me-2 flex-shrink-0" style="width: 30px; height: 30px; background-color: {{ $answer->user->icon }}"></div>
              <strong>{{ $answer->user->name }}</strong>

              @if ($answer->is_best)
              <span class="badge bg-dark ms-auto d-flex align-items-center">
                <i class="bi bi-check2-circle me-1"></i> Best answer
              </span>
              @endif
            </div>
            <p class="text-muted mb-1">{{ $answer->body }}</p>
            <div class="d-flex justify-content-between text-muted small">
              <div>
                <i class="bi bi-heart"></i> {{ $answer->likes }}
              </div>
              <i class="bi bi-three-dots"></i>
            </div>
          </div>
        </div>
      @endforeach

    </div>

    {{-- サイドバー：右側（col-md-3） --}}
    <div class="col-md-3 d-none d-md-block">
      @include('components.sidebar-menu') {{-- サイドバーのBladeファイルをここに指定 --}}
    </div>
  </div> {{-- .row --}}
</div> {{-- .container --}}
@endsection
