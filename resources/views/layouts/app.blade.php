<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="//unpkg.com/alpinejs"></script>

    <!-- Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places"
        loading="async"></script>
</head>

<body>
    <div id="app">
        @if (!in_array(Route::currentRouteName(), ['login', 'register', 'chatRoom.show']))
            <nav x-data="{ searching: false }" class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid d-flex justify-content-between align-items-center flex-nowrap">
                    <a class="navbar-brand ms-3" href="{{ url('/') }}" x-show="!searching" x-transition>
                        <img src="{{ asset('images/Zinnbei1.png') }}" alt="icon"
                            style="width: auto; height: 100px;">
                    </a>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto mt-3 d-flex flex-row">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                @php
                                    $path = request()->path();
                                    $searchAction = route('search');
                                    $placeholder = 'Search all content...';

                                    if (request()->is('event*')) {
                                        $searchAction = route('event.search');
                                        $placeholder = 'Search Events...';
                                    } elseif (request()->is('food*')) {
                                        $searchAction = route('food.search');
                                        $placeholder = 'Search Foods...';
                                    } elseif (request()->is('item*')) {
                                        $searchAction = route('item.search');
                                        $placeholder = 'Search Items...';
                                    } elseif (request()->is('travel*')) {
                                        $searchAction = route('travel.search');
                                        $placeholder = 'Search Travels...';
                                    } elseif (request()->is('transportation*')) {
                                        $searchAction = route('transportation.search');
                                        $placeholder = 'Search Transportation...';
                                    } elseif (request()->is('question*')) {
                                        $searchAction = route('question.search');
                                        $placeholder = 'Search Questions...';
                                    }
                                @endphp

                                <form action="{{ $searchAction }}" method="GET"
                                    class="search-box mb-3 d-flex bg-white rounded-pill px-3 py-2">
                                    <input type="text" name="search" placeholder="{{ $placeholder }}"
                                        class="form-control border-2 me-2"
                                        @focus="if (window.innerWidth < 768) searching = true" @blur="searching = false">
                                    <button class="btn btn-info text-white rounded-circle">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </li>

                            <!-- Create Post -->
                            <li class="nav-item me-2" title="Create Post">
                                <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                    <i class="fa-solid fa-circle-plus text-info icon-sm"></i>
                                </a>
                            </li>

                            <!-- Account -->
                            <li class="nav-item dropdown position-relative">
                                <button class="btn btn-shadow-none nav-link dropdown-toggle" id="account-dropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                            class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-info icon-sm"></i>
                                    @endif

                                    @if ($latestWarning)
                                        <span
                                            class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger"
                                            style="font-size: 0.5rem; cursor: pointer;" data-bs-toggle="modal"
                                            data-bs-target="#warningModal">
                                            !
                                        </span>
                                    @endif
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">
                                    @can('admin')
                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i> Admin
                                        </a>
                                        <hr class="dropdown-divider">
                                    @endcan

                                    <a href="{{ route('profile.index', Auth::user()->id) }}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user text-info"></i> Profile
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-form-bracket"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        @endif

        <main class="py-0">
            @if (request()->is('admin/*'))
                @include('admin.sidebar')
            @endif

            <div class="container py-4">
                @if (session('success'))
                    <div id="successMessage"
                        class="alert alert-danger alert-dismissible fade show fixed-top mx-auto mt-3"
                        style="max-width: 600px; z-index: 1050;" role="alert">
                        {{ session('success') }}
                    </div>

                    <script>
                        setTimeout(() => {
                            const msg = document.getElementById('successMessage');
                            if (msg) {
                                msg.style.opacity = '0';
                                setTimeout(() => msg.remove(), 1000); // 完全に削除
                            }
                        }, 2000); // 3秒後にフェードアウト開始
                    </script>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @include('posts.components.sidebar-mobile')
    @include('posts.components.post-category-modal')
    @include('posts.components.forms.post-form-other-modal')
    @include('posts.components.forms.post-form-event-modal')
    @include('posts.components.forms.post-form-food-modal')
    @include('posts.components.forms.post-form-item-modal')
    @include('posts.components.forms.post-form-question-modal')
    @include('posts.components.forms.post-form-transportation-modal')
    @include('posts.components.forms.post-form-travel-modal')
    @include('posts.components.modals.getreport')

    @stack('scripts')
</body>

</html>
