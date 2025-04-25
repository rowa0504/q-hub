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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        {{-- Navbarをlogin・registerページでは非表示にする --}}
        @if (!in_array(Route::currentRouteName(), ['login', 'register']))
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid d-flex justify-content-between align-items-center flex-nowrap">
                    <a class="navbar-brand ms-3" href="{{ url('/') }}">
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
                            <!-- Search -->
                            <li class="nav-item">
                                <form class="search-box mb-3 d-flex bg-white rounded-pill px-3 py-2">
                                    <input type="text" placeholder="Search ..." class="form-control border-2 me-2">
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
                            <li class="nav-item dropdown">
                                <button class="btn btn-shadow-none nav-link dropdown-toggle" id="account-dropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Auth::user()->avatar)
                                        <img src="#" alt="#" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-info icon-sm"></i>
                                    @endif
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">
                                    @can('admin')
                                        <a href="#" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i> Admin
                                        </a>
                                        <hr class="dropdown-divider">
                                    @endcan

                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item">
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

        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    @if (request()->is('admin/*'))
                        <div class="col-3">
                            <div class="list-group">
                                <a href="#"
                                    class="list-group-item {{ request()->is('admin/users') ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i> Users
                                </a>
                                <a href="#"
                                    class="list-group-item {{ request()->is('admin/posts') ? 'active' : '' }}">
                                    <i class="fa-solid fa-newspaper"></i> Posts
                                </a>
                                <a href="#"
                                    class="list-group-item {{ request()->is('admin/foods') ? 'active' : '' }}">
                                    <i class="fa-solid fa-utensils"></i> foods
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="{{ request()->is('admin/*') ? 'col-9' : 'col-12' }}">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    {{-- スマホ用ハンバーガー --}}
<button class="btn d-md-none position-fixed hamburger-menu" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

{{-- スマホ用オーバーレイ（背景を暗くする） --}}
<div id="sidebarOverlay" class="sidebar-overlay d-md-none" onclick="toggleSidebar()"></div>

{{-- スマホ用サイドバー --}}
<div class="sidebar-mobile d-md-none" id="mobileSidebar">
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/Zinnbei1.png') }}" alt="icon" style="height: 60px;">
        </a>
        <button class="btn btn-outline-secondary btn-sm" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="p-3">
        @include('components.sidebar-menu')
    </div>
</div>

{{-- スマホ用サイドバーのスタイル --}}
<script>
    function toggleSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const hamburger = document.querySelector('.hamburger-menu');

    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');

    // サイドバーが表示されたらハンバーガーを非表示に、非表示なら表示に
    if (sidebar.classList.contains('show')) {
        hamburger.style.display = 'none';
    } else {
        hamburger.style.display = 'block';
    }
}
</script>

    @include('components.post-category-modal')
    @include('components.forms.post-form-other-modal')
    @include('components.forms.post-form-event-modal')
    @include('components.forms.post-form-food-modal')
    @include('components.forms.post-form-item-modal')
    @include('components.forms.post-form-question-modal')
    @include('components.forms.post-form-transportation-modal')
    @include('components.forms.post-form-travel-modal')
    </div>
</body>

</html>
