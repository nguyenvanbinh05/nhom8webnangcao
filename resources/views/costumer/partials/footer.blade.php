<footer class="footer">
    <div class="main-content">
        <div class="row">
            <div class="column1">
                <a href=""><img src="{{ asset('images/logo/Coffee.svg') }}" alt="Coffee"></a>
                <p class="desc">Một quán coffee thành công không chỉ đến từ hương vị ly cà phê, mà còn từ cách bạn quản
                    lý vận hành phía sau. Giải pháp của chúng tôi giúp bạn nắm bắt mọi thứ trong tầm tay, để mỗi ngày
                    kinh doanh đều nhẹ nhàng và hiệu quả hơn.</p>
            </div>
            <div class="column2">
                <h3 class="title">Liên kết nhanh</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ url('/') }}#about">Giới thiệu</a></li>
                    <li><a href="{{ route('menu.index') }}">Menu</a></li>
                    <li><a href="{{ url('/') }}#contact">Liên hệ</a></li>
                    <li><a href="{{ route('cart') }}">Giỏ hàng</a></li>
                </ul>
            </div>
            <div class="column3">
                <h3 class="title">Liên hệ</h3>
                <ul>
                    <li><a href=""><strong>Địa chỉ:</strong> 123 Đường ABC, Quận 1, TP. Hồ Chí Minh</a></li>
                    <li><a href=""><strong>Email:</strong> contact@coffeehouse.vn</a></li>
                    <li><a href=""><strong>Hotline:</strong> 0909 123 456</a></li>
                </ul>
            </div>
            <div class="column4">
                <h3 class="title">Kết nối với chúng tôi</h3>
                <ul>
                    <li><a href=""><img src="{{ asset('images/icons/logos_facebook.svg') }}" alt="Facebook"></a></li>
                    <li><a href=""><img src="{{ asset('images/icons/icons_instagram.svg') }}" alt="Instagram"></a></li>
                    <li><a href=""><img src="{{ asset('images/icons/devicon_github.svg') }}" alt="Github"></a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Coffee Manager | Thiết kế bởi Nhóm Quản Lý Quán Coffee</p>
        </div>
    </div>
</footer>