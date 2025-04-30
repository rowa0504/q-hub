<!-- ユーザー -->
@if(Auth::check())
    <div class="d-flex align-items-center mb-3 text-dark">
        <img src="{{ Auth::user()->avatar }}" width="40" height="40" class="rounded-circle me-2 avatar-sm" alt="Avatar">
        <span>{{ Auth::user()->name }}</span>
    </div>
@else
    {{-- ゲストユーザー用の表示が必要ならここに書く --}}
    <div class="d-flex align-items-center mb-3 text-dark">
        <img src="/default-avatar.png" width="40" height="40" class="rounded-circle me-2 avatar-sm" alt="Default Avatar">
        <span>Guest</span>
    </div>
@endif


<hr class="text-dark">

<!-- メニューリンク -->
<div class="d-flex flex-column gap-3">
    <a href="{{ route('event.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-calendar-days"></i>
        Event</a>
    <a href="{{ route('food.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-burger"></i>
        Food</a>
    <a href="{{ route('item.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-gift"></i> Item</a>
    <a href="{{ route('travel.index') }}" class="text-dark text-decoration-none"><i
            class="fa-solid fa-location-dot"></i> Travel</a>
    <a href="{{ route('transportation.index') }}" class="text-dark text-decoration-none"><i class="fa-solid fa-car"></i>
        Transportation</a>
    <a href="{{ route('question.index') }}" class="text-dark text-decoration-none"><i
            class="fa-solid fa-circle-question"></i> Question</a>
</div>


<hr class="text-dark">

<div class="d-flex flex-column gap-3">
    <a href="#" class="text-dark text-decoration-none"><i class="fa-solid fa-flag"></i> Report</a>
    <a href="#" class="text-dark text-decoration-none"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</div>
