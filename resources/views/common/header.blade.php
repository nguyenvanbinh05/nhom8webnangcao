<header class="header">
    <div class="header__toggle-sidebar">
        <i class="fa-solid fa-bars header__toggle-sidebar-icon"></i>
    </div>
    <div class="header__right">
        <div class="account-area account-dropdown">
            @auth
            <button class="account-btn" type="button">
                <span class="account-name">{{ Auth::user()->name }}</span>
                <svg class="chevron" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>
            <ul class="account-menu">
                <!-- <li><a href="{{ route('profile.edit') }}">Tài khoản</a></li> -->
                <li class="separator"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Đăng xuất</button>
                    </form>
                </li>
            </ul>
            @else
            <a href="{{ route('login') }}" class="account-link">Đăng nhập</a>
            <a href="{{ route('register') }}" class="account-link">Đăng ký</a>
            @endauth
        </div>
    </div>
</header>