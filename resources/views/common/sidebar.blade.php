<div class="sidebar">
    <div class="sidebar__header">
        <!-- <i class="fa-solid fa-bars"></i> -->
        <h2 class="sidebar__title">Coffee</h2>
    </div>
    <ul class="sidebar__menu">
        <li class="sidebar__item {{request()->routeIs('homePage') ? 'sidebar__item--active' : ''}}">
            <a href="{{ route('homePage') }}" class="sidebar__link">
                <i class="fas fa-home sidebar__icon"></i>
                <span class="sidebar__text">Trang chủ</span>
            </a>
        </li>
        <li class="sidebar__item {{request()->routeIs('pos') ? 'sidebar__item--active' : ''}}">
            <a href="{{ route('pos') }}" class="sidebar__link">
                <i class="fas fa-shopping-cart sidebar__icon"></i>
                <span class="sidebar__text">Pos</span>
            </a>
        </li>
        <li class="sidebar__item">
            <a href="#" class="sidebar__link">
                <i class="fas fa-shopping-cart sidebar__icon"></i>
                <span class="sidebar__text">Quản lý đơn hàng</span>
            </a>
        </li>
        <li class="sidebar__item {{ in_array(Route::currentRouteName(), ['productManagement', 'categoryManagement']) ? 'sidebar__item--active' : '' }}">
            <a href="#" class="sidebar__link sidebar__link-dropdown">
                <i class="fas fa-boxes sidebar__icon"></i>
                <div class="sidebar__dropdowm-text">
                    <span class="sidebar__text">Quản lý sản phẩm</span>
                    <i class="fa-solid fa-chevron-down dropdown__icon"></i>
                </div>
            </a>
            <ul class="sidebar__submenu sidebar__submenu--hidden">
                <li class="sidebar__subitem"><a href="{{ route('productManagement') }}" class="sidebar__sublink">danh sách sản phẩm</a></li>
                <li class="sidebar__subitem"><a href="{{ route('categoryManagement') }}" class="sidebar__sublink">danh mục sản phảm</a></li>
            </ul>
        </li>
        <li class="sidebar__item {{request()->routeIs('accountManagement') ? 'sidebar__item--active' : ''}}">
            <a href="{{ route('accountManagement') }}" class="sidebar__link">
                <i class="fas fa-users sidebar__icon"></i>
                <span class="sidebar__text">Quản lý tài khoản</span>
            </a>
        </li>
        <li class="sidebar__item">
            <a href="#" class="sidebar__link sidebar__link-dropdown">
                <i class="fas fa-warehouse sidebar__icon"></i>
                <div class="sidebar__dropdowm-text">
                    <span class="sidebar__text">Quản lý kho nguyên liệu</span>
                    <i class="fa-solid fa-chevron-down dropdown__icon"></i>
                </div>
            </a>
            <ul class="sidebar__submenu sidebar__submenu--hidden">
                <li class="sidebar__subitem"><a href="{{ route('ingredients.index') }}" class="sidebar__sublink">danh sách nguyên liệu</a></li>
                <li class="sidebar__subitem"><a href="{{ route('supplier.index') }}" class="sidebar__sublink">Nhà cung cấp</a></li>
                <!-- <li class="sidebar__subitem"><a href="#" class="sidebar__sublink">nhập nguyên liệu</a></li>
                <li class="sidebar__subitem"><a href="#" class="sidebar__sublink">xuất nguyên liệu</a></li>
                <li class="sidebar__subitem"><a href="#" class="sidebar__sublink">lịch sử nhập-xuất</a></li> -->
            </ul>
        </li>
        <li class="sidebar__item sidebar__item--logout">
            <a href="#" class="sidebar__link">
                <i class="fas fa-sign-out-alt sidebar__icon"></i>
                <span class="sidebar__text">Đăng xuất</span>
            </a>
        </li>
    </ul>
</div>
