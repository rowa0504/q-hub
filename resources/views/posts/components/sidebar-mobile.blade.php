{{-- スマホ用ハンバーガー --}}
    <button class="btn d-md-none position-fixed hamburger-menu" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    {{-- スマホ用オーバーレイ --}}
    <div id="sidebarOverlay" class="sidebar-overlay d-md-none" onclick="toggleSidebar()"></div>

    {{-- スマホ用サイドバー --}}
    <div class="sidebar-mobile d-md-none" id="mobileSidebar">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/Zinnbei1.png') }}" alt="icon" style="height: 100px;">
            </a>
            <button class="btn btn-outline-secondary btn-sm" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="sidebar-sticky p-2">
            {{-- プロフィール --}}
            <div class="d-flex align-items-center mb-3 text-dark">
                @auth
                    <a href="{{ route('profile.index', Auth::user()->id) }}"
                        class="text-decoration-none d-flex align-items-center">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" class="rounded-circle me-2 avatar-sm" alt="Avatar">
                        @else
                            <i class="fa-solid fa-circle-user fa-3x text-secondary me-2"></i>
                        @endif
                        <span class="text-dark">{{ Auth::user()->name }}</span>
                    </a>
                @else
                    <i class="fa-solid fa-circle-user fa-3x text-secondary me-2"></i>
                    <span>Guest</span>
                @endauth
            </div>

            <hr class="text-dark">

            {{-- メニュー --}}
            <div class="d-flex flex-column gap-3">
                <a href="{{ route('event.index') }}" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-calendar-days"></i> Event</a>
                <a href="{{ route('food.index') }}" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-burger"></i> Food</a>
                <a href="{{ route('item.index') }}" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-gift"></i> Item</a>
                <a href="{{ route('travel.index') }}" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-location-dot"></i> Travel</a>
                <a href="{{ route('transportation.index') }}" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-car"></i> Transportation</a>
                <a href="{{ route('question.index') }}" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-circle-question"></i> Question</a>
            </div>

            <hr class="text-dark">

            {{-- ログアウト --}}
            @auth
                <a href="#" class="text-dark text-decoration-none"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
        </div>
    </div>

    {{-- サイドバースクリプト --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const hamburger = document.querySelector('.hamburger-menu');

            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');

            hamburger.style.display = sidebar.classList.contains('show') ? 'none' : 'block';
        }
    </script>
