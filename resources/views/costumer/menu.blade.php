@extends('costumer.layouts.myapp')
@section('title', 'Menu')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endpush
@section('content')
    <section class="menu-section fade-in">
        <div class="main-content menu-container">
            <!-- Sidebar -->
            <div class="menu-sidebar">
                <ul>
                    <li><a href="#" class="active">Tất cả</a></li>
                    <li><a href="#">Cà phê</a></li>
                    <li><a href="#">Sinh Tố</a></li>
                    <li><a href="#">Bánh</a></li>
                </ul>
            </div>

            <!-- Nội dung -->
            <div class="menu-content">
                <!-- Nhóm Cà phê -->
                <div class="menu-group">
                    <h2>Cà phê</h2>
                    <div class="menu-products">
                        @foreach (range(1, 7) as $i)
                            <a href="#" class="menu-card">
                                <div class="menu-card-img">
                                    <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà Phê Đen">
                                </div>
                                <div class="menu-card-info">
                                    <p class="menu-card-name">Cà phê Đen {{ $i }}</p>
                                    <p class="menu-card-price">55.000 đ</p>
                                </div>
                                <button class="menu-card-cart" title="Thêm vào giỏ hàng">
                                    <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                                </button>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Nhóm Sinh Tố -->
                <div class="menu-group">
                    <h2>Sinh Tố</h2>
                    <div class="menu-products">
                        <a href="#" class="menu-card">
                            <div class="menu-card-img">
                                <img src="{{ asset('images/products/sinhto.svg') }}" alt="Sinh tố Matcha">
                            </div>
                            <div class="menu-card-info">
                                <p class="menu-card-name">Sinh tố Matcha</p>
                                <p class="menu-card-price">50.000 đ</p>
                            </div>
                            <button class="menu-card-cart" title="Thêm vào giỏ hàng">
                                <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Nhóm Bánh -->
                <div class="menu-group">
                    <h2>Bánh</h2>
                    <div class="menu-products">
                        @foreach (range(1, 4) as $i)
                            <a href="#" class="menu-card">
                                <div class="menu-card-img">
                                    <img src="{{ asset('images/products/banhmi.svg') }}" alt="Bánh Mì">
                                </div>
                                <div class="menu-card-info">
                                    <p class="menu-card-name">Bánh Mì {{ $i }}</p>
                                    <p class="menu-card-price">60.000 đ</p>
                                </div>
                                <button class="menu-card-cart" title="Thêm vào giỏ hàng">
                                    <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                                </button>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection