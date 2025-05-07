<!-- ユーザー -->
<div class="d-flex align-items-center mb-3 text-dark">
    @if (Auth::check())
        <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none d-flex align-items-center">
            @if (Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" class="rounded-circle me-2 avatar-sm"
                     alt="Avatar" style="width: 40px; height: 40px; object-fit: cover;">
            @else
                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                     style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-circle-user fa-3x text-secondary"></i>
                </div>
            @endif
            <span class="text-dark">{{ Auth::user()->name }}</span>
        </a>
    @else
        <!-- ゲストの場合 -->
        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
             style="width: 40px; height: 40px;">
            <i class="fa-solid fa-circle-user fa-3x text-secondary"></i>
        </div>
        <span>Guest</span>
    @endif
</div>

<hr class="text-dark">

<!-- メニューリンク -->
<div class="d-flex flex-column gap-3">
    <a href="{{ route('event.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-calendar-days"></i> Event</a>
    <a href="{{ route('food.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-burger"></i> Food</a>
    <a href="{{ route('item.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-gift"></i> Item</a>
    <a href="{{ route('travel.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-location-dot"></i> Travel</a>
    <a href="{{ route('transportation.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-car"></i> Transportation</a>
    <a href="{{ route('question.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-circle-question"></i> Question</a>
</div>

<hr class="text-dark">

<!-- ログアウトリンク -->
<div class="d-flex flex-column gap-3">
    <a href="#" class="text-dark text-decoration-none"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
