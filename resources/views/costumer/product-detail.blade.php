@extends('costumer.layouts.myapp')
@section('title', 'Cà Phê Đen')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
@endpush
@section('content')
    <section class="product-detail fade-in">
        <div class="main-content">
            <div class="product-body">
                <!-- Cột trái: hình ảnh sản phẩm -->
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen" id="mainImage">
                    </div>
                    <div class="thumb-list">
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="thumb 1" class="active"
                            onclick="changeImage(this)">
                        <img src="{{ asset('images/products/sinhto.svg') }}" alt="thumb 2" onclick="changeImage(this)">
                    </div>
                </div>

                <!-- Cột phải: thông tin sản phẩm -->
                <div class="product-info">
                    <h1 class="product-title">Cà phê đen</h1>
                    <p class="product-status">Tình trạng: <span>Còn hàng</span></p>

                    <div class="product-price">
                        <span class="price-current">55.000đ</span>
                        <span class="price-old">60.000đ</span>
                    </div>

                    <div class="product-option">
                        <p>Kích thước:</p>
                        <div class="sizes">
                            <button class="size active">S</button>
                            <button class="size">M</button>
                            <button class="size">L</button>
                        </div>
                    </div>

                    <div class="product-quantity">
                        <label for="quantity">Số lượng:</label>
                        <div class="quantity-box">
                            <input id="quantity" type="number" value="1" min="1">
                        </div>
                    </div>


                    <div class="product-action">
                        <button class="btn-buy">Mua ngay</button>
                        <button class="btn-add">Thêm vào giỏ</button>
                    </div>
                </div>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="product-description">
                <h2>Mô tả sản phẩm</h2>
                <p>
                    Cà Phê Đen là lựa chọn hoàn hảo dành cho những ai yêu thích vị đắng đậm đà và hương thơm đặc trưng của
                    hạt cà phê rang xay nguyên chất.
                </p>
            </div>
            <!-- SẢN PHẨM CÙNG LOẠI -->
            <section class="related-products">
                <div class="title">
                    <h2>Sản Phẩm Cùng Loại</h2>
                </div>
                <div class="main-content">
                    <div class="related-list">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="related-card">
                                <div class="related-image">
                                    <a href="#"><img src="{{ asset('images/products/capheden.svg') }}" alt="Cà Phê Đen"></a>
                                </div>
                                <div class="related-info">
                                    <a href="#" class="related-name">Cà phê Đen {{ $i }}</a>
                                    <p class="related-price">55.000 đ</p>
                                </div>
                                <button class="related-cart-btn" title="Thêm vào giỏ hàng">
                                    <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                                </button>
                            </div>
                        @endfor
                    </div>
                </div>
            </section>


        </div>
    </section>
    <script>
        function changeImage(element) {
            document.getElementById('mainImage').src = element.src;
            document.querySelectorAll('.thumb-list img').forEach(img => img.classList.remove('active'));
            element.classList.add('active');
        }
    </script>

@endsection