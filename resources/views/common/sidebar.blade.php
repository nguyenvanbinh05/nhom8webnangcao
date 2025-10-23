<div class="sidebar">
    <div class="sidebar__header">
        <img src="{{ asset('images/logo/logo-web.svg') }}" class="logo-icon" alt="Logo nhỏ">
        <h2 class="sidebar__title">Coffee</h2>
    </div>
    <ul class="sidebar__menu">
        <li class="sidebar__item {{ request()->routeIs('homePage') ? 'item-active' : '' }}">
            <a href="{{ route('homePage') }}">
                <i class="fas fa-home sidebar__icon"></i>
                <span class="sidebar__text">Trang chủ</span>
            </a>
        </li>
        <li class="sidebar__item {{ request()->routeIs('orderManagement.*') ? 'item-active' : '' }}">
            <a href="{{ route('orderManagement.index') }}">
                <i class="fas fa-shopping-cart sidebar__icon"></i>
                <span class="sidebar__text">Quản lý đơn hàng</span>
            </a>
        </li>
        @if(Auth::user()->role === 'admin')
        <li class="sidebar__item {{ request()->routeIs('category.*') ? 'item-active' : '' }}">
            <a href="{{ route('category.index') }}">
                <i class="fas fa-boxes sidebar__icon"></i>
                <span class="sidebar__text">Quản lý danh mục</span>
            </a>
        </li>
        <li class="sidebar__item {{ request()->routeIs('adminProduct.*') ? 'item-active' : '' }}">
            <a href="{{ route('adminProduct.index') }}">
                <i class="fas fa-boxes sidebar__icon"></i>
                <span class="sidebar__text">Quản lý sản phẩm</span>
            </a>
        </li>
        <li class="sidebar__item {{ request()->routeIs('accounts.*') ? 'item-active' : '' }}">
            <a href="{{ route('accounts.index') }}">
                <i class="fas fa-users sidebar__icon"></i>
                <span class="sidebar__text">Quản lý tài khoản</span>
            </a>
        </li>
        @endif
    </ul>
</div>






<!-- <li class="sidebar__item">
            <a href="#" class="sidebar__link sidebar__link-dropdown">
                <i class="fas fa-warehouse sidebar__icon"></i>
                <div class="sidebar__dropdowm-text">
                    <span class="sidebar__text">Quản lý kho nguyên liệu</span>
                    <i class="fa-solid fa-chevron-down dropdown__icon"></i>
                </div>
            </a>
            <ul class="sidebar__submenu sidebar__submenu--hidden">
                <li class="sidebar__subitem"><a href="{{ route('ingredients.index') }}" class="sidebar__sublink">danh
                        sách nguyên liệu</a></li>
                <li class="sidebar__subitem"><a href="{{ route('supplier.index') }}" class="sidebar__sublink">Nhà cung
                        cấp</a></li>
                <li class="sidebar__subitem"><a href="#" class="sidebar__sublink">nhập nguyên liệu</a></li>
                <li class="sidebar__subitem"><a href="#" class="sidebar__sublink">xuất nguyên liệu</a></li>
                <li class="sidebar__subitem"><a href="#" class="sidebar__sublink">lịch sử nhập-xuất</a></li>
            </ul>
        </li> -->