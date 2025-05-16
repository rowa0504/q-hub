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
                <a class="nav-link text-white {{ request()->is('admin/comments') ? 'fw-bold' : '' }}"
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
                <a class="nav-link text-white {{ request()->is('admin/chatMessages') ? 'fw-bold' : '' }}"
                    href="{{ route('admin.chatMessages') }}">
                    <i class="fa-brands fa-rocketchat me-2"></i> ChatMessage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('admin/reports') ? 'fw-bold' : '' }}"
                    href="{{ route('admin.reports') }}">
                    <i class="fa-solid fa-flag me-2"></i> Reports
                </a>
            </li>
        </ul>
    </div>
