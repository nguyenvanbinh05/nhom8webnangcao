<header class="header sticky">
    <div class="main-content">
        <div class="body">
            <div class="shop-logo">
                <a href="{{ route('home') }}"><img src="{{ asset('images/logo/Logo.svg') }}" alt="Coffee"></a>
            </div>

            <nav class="nav">
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ url('/') }}#about">Giới thiệu</a></li>
                    <li><a href="{{ route('menu.index') }}">Menu</a></li>
                    <li><a href="{{ url('/') }}#contact">Liên hệ</a></li>
                </ul>
            </nav>

            <div class="search-account">
                <ul>
                    <li><a href="#"><img src="{{ asset('images/icons/search.svg') }}" alt="Tìm kiếm"></a></li>
                    <li><a href="{{ route('cart.index') }}" class="nav-cart"><img
                                src="{{ asset('images/icons/cart.svg') }}" alt="Giỏ Hàng">
                            <span class="cart-badge" id="cart-count">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </li>

                    {{-- Chọn 1 trong 2 khối dưới: (Cách 1) hoặc (Cách 2) --}}
                    {{-- === Cách 1: đơn giản ngang === --}}
                    <li class="account-area account-dropdown">
                        @auth
                            <button class="account-btn" type="button">
                                <img src="{{ asset('images/icons/account.svg') }}" alt="Tài khoản" class="account-icon">
                                <span class="account-name">{{ Auth::user()->name }}</span>
                                <svg class="chevron" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </button>
                            <ul class="account-menu">
                                {{-- nếu muốn có trang hồ sơ riêng thì để link ở đây --}}
                                <li><a href="{{ route('profile.edit') }}">Tài khoản</a></li>
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
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>