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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/Zinnbei1.png') }}" alt="icon"
                        style="width: auto; height: 100px;">
                </a>


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto mt-3 d-flex flex-row">
                    <!-- Authentication Links -->
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


                        <!-- Create Post -->
                        <li class="nav-item me-2" title="Create Post">
                            <a href="#" class="nav-link"> <!-- Add your post creation route here -->
                                <i class="fa-solid fa-circle-plus text-info icon-sm"></i>
                            </a>
                        </li>

                        <!-- Account -->
                        <li class="nav-item dropdown">
                            <button class="btn btn-shadow-none nav-link dropdown-toggle" id="account-dropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->avatar)
                                    <img src="#" alt="#" class="rounded-circle avatar-sm">
                                    <!-- Add your avatar URL here -->
                                @else
                                    <i class="fa-solid fa-circle-user text-info icon-sm"></i>
                                @endif
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">
                                <!-- SOON Admin Controls -->
                                @can('admin')
                                    <a href="#" class="dropdown-item"> <!-- Add your admin route here -->
                                        <i class="fa-solid fa-user-gear"></i> Admin
                                    </a>

                                    <hr class="dropdown-divider">
                                @endcan
                                <!-- Profile -->
                                <a href="#" class="dropdown-item"> <!-- Add your profile route here -->
                                    <i class="fa-solid fa-circle-user"></i> Profile
                                </a>

                                <!-- Logout -->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
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
    </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- SOON Admin Menu col-3 -->
                @if (request()->is('admin/*'))
                    <div class="col-3">
                        <div class="list-group">
                            <a href="#"
                                class="list-group-item  {{ request()->is('admin/users') ? 'active' : '' }}">
                                <i class="fa-solid fa-users"></i> Users
                            </a>
                            <a href="#"
                                class="list-group-item {{ request()->is('admin/posts') ? 'active' : '' }}">
                                <i class="fa-solid fa-newspaper"></i> Posts
                            </a>
                            <a href="#"
                                class="list-group-item {{ request()->is('admin/categories') ? 'active' : '' }}">
                                <i class="fa-solid fa-tags"></i> Categories
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


    <!-- Category Selection Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <h5 class="modal-title text-center mb-3">What category of information do you want to share?</h5>
                <div class="d-grid gap-2">
                    @foreach (['event', 'food', 'item', 'travel', 'transportation', 'question', 'other'] as $category)
                        @switch($category)
                            @case('other')
                                <a href="#" class="btn btn-info text-white text-capitalize" data-bs-dismiss="modal"
                                    data-bs-toggle="modal" data-bs-target="#otherPostModal">
                                    {{ $category }}
                                </a>
                            @break

                            @default
                                <a href="#" class="btn btn-info text-white text-capitalize">
                                    {{ $category }}
                                </a>
                        @endswitch
                    @endforeach
                    <button class="btn btn-outline-info" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!--  postFormModal を追加 -->
    <div class="modal fade" id="otherPostModal" tabindex="-1" aria-labelledby="otherPostModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title text-info" id="otherPostModalLabel">Create Other Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <!-- Image preview -->
                        <div class="mb-3 text-center">
                            <img id="imagePreview" src="https://via.placeholder.com/300x200" alt="Image Preview"
                                class="img-fluid rounded">
                        </div>

                        <!-- File input -->
                        <div class="mb-3">
                            <input class="form-control" type="file" id="imageInput" accept="image/*">
                        </div>

                        <!-- Title input -->
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Enter your post title...">
                        </div>

                        <!-- Description input -->
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Enter your post description..." rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info text-white">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('imagePreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    </div>
</body>

</html>
