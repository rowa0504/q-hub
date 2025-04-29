<!-- ユーザー -->
<div class="d-flex align-items-center mb-3 text-dark">
    <img src="https://t3.ftcdn.net/jpg/10/95/73/04/240_F_1095730489_Y6aXUFzW3U60YbZvMJ7wVMwYTQ8o81c0.jpg"
        class="rounded-circle me-2 avatar-sm" alt="Avatar">
    <span>{{ Auth::user()->name ?? 'username' }}</span>
</div>

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
