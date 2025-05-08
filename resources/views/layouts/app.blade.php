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

    {{-- For Edit --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="//unpkg.com/alpinejs" defer></script>
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
                            <li class="nav-item dropdown position-relative">
                                <button class="btn btn-shadow-none nav-link dropdown-toggle" id="account-dropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                            class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-info icon-sm"></i>
                                    @endif

                                    {{-- 通知バッジ --}}
                                    {{-- @if (Auth::user()->latestWarning ?? false) --}}
                                    <span
                                    class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.5rem; cursor: pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#warningModal">
                                    !
                                    </span>
                                    {{-- @endif --}}
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
                {{-- 管理画面レイアウト --}}
                <div class="d-flex">
                    {{-- サイドバー --}}
                    <div class="bg-dark text-white p-3" style="width: 250px; height: 100vh;">
                        <h5 class="mb-4">QHub Admin</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('admin/dashboard') ? 'fw-bold' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-chart-line me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('admin/users') ? 'fw-bold' : '' }}"
                                    href="{{ route('admin.users') }}">
                                    <i class="fa-solid fa-users me-2"></i> Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('admin/posts') ? 'fw-bold' : '' }}"
                                    href="{{ route('admin.posts') }}">
                                    <i class="fa-solid fa-newspaper me-2"></i> Posts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('admin/coments') ? 'fw-bold' : '' }}"
                                    href="{{ route('admin.comments') }}">
                                    <i class="fa-solid fa-tags me-2"></i> Comments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('admin/answers') ? 'fw-bold' : '' }}"
                                    href="{{ route('admin.answers') }}">
                                    <i class="fa-solid fa-circle-question me-2"></i> Answers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('admin/reports') ? 'fw-bold' : '' }}"
                                    href="{{ route('admin.reports') }}">
                                    <i class="fa-solid fa-flag me-2"></i> Reports
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('admin/report-sent') ? 'fw-bold' : '' }}"
                                    href="{{ route('admin.report_sent') }}">
                                    <i class="fa-solid fa-envelope-circle-check me-2"></i> Reports Sent
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- メインコンテンツ --}}
                    <div class="flex-grow-1 p-4" style="background-color: #f8f9fa; min-height: 100vh;">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold">@yield('title', 'Admin Dashboard')</h2>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-outline-danger btn-sm">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf</form>
                        </div>

                        {{-- 管理画面の中身 --}}
                        @yield('content')
                    </div>
                </div>
            @else
                {{-- 通常画面 --}}
                <div class="container py-4">
                    @yield('content')
                </div>
            @endif
        </main>
    </div>
    {{-- スマホ用ハンバーガー --}}
    <button class="btn d-md-none position-fixed hamburger-menu" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    {{-- スマホ用オーバーレイ（背景を暗くする） --}}
    <div id="sidebarOverlay" class="sidebar-overlay d-md-none" onclick="toggleSidebar()"></div>

    {{-- スマホ用サイドバー --}}<a href="#">
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
                @include('posts.components.sidebar-menu')
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
                @include('posts.components.sidebar-menu')
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

        @include('posts.components.post-category-modal')
        @include('posts.components.forms.post-form-other-modal')
        @include('posts.components.forms.post-form-event-modal')
        @include('posts.components.forms.post-form-food-modal')
        @include('posts.components.forms.post-form-item-modal')
        @include('posts.components.forms.post-form-question-modal')
        @include('posts.components.forms.post-form-transportation-modal')
        @include('posts.components.forms.post-form-travel-modal')
        @include('posts.components.modals.getreport')

        </div>
        @stack('scripts')
</body>

</html>
