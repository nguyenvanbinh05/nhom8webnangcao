@extends('costumer.layouts.myapp')
@section('title', 'Giỏ hàng')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <section class="cart-section fade-in">
        <div class="main-content">
            <h2 class="cart-title">Giỏ hàng</h2>

            <div class="cart-container">
                <!-- DANH SÁCH SẢN PHẨM -->
                <div class="cart-list">
                    <div class="cart-item">
                        <button class="remove-btn" title="Xóa">×</button>
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                        <div class="cart-info">
                            <a href="" class="product-name">
                                <h3>Cà phê đen</h3>
                            </a>
                            <p class="size">S</p>
                            <p class="price">55.000đ</p>
                        </div>
                        <div class="quantity-control">
                            <button>-</button>
                            <span>1</span>
                            <button>+</button>
                        </div>
                    </div>

                    <div class="cart-item">
                        <button class="remove-btn" title="Xóa">×</button>
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                        <div class="cart-info">
                            <a href="" class="product-name">
                                <h3>Cà phê đen</h3>
                            </a>
                            <p class="size">S</p>
                            <p class="price">55.000đ</p>
                        </div>
                        <div class="quantity-control">
                            <button>-</button>
                            <span>1</span>
                            <button>+</button>
                        </div>
                    </div>

                    <div class="cart-item">
                        <button class="remove-btn" title="Xóa">×</button>
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                        <div class="cart-info">
                            <a href="" class="product-name">
                                <h3>Cà phê đen</h3>
                            </a>
                            <p class="size">S</p>
                            <p class="price">55.000đ</p>
                        </div>
                        <div class="quantity-control">
                            <button>-</button>
                            <span>1</span>
                            <button>+</button>
                        </div>
                    </div>
                </div>

                <!-- HÓA ĐƠN -->
                <div class="cart-summary">
                    <h4>HẸN NGÀY THANH TOÁN</h4>
                    <label for="delivery-date">Ngày nhận hàng</label>
                    <input type="date" id="delivery-date" value="2025-10-12">
                    <div class="total">
                        <span>TỔNG CỘNG</span>
                        <strong>165.000đ</strong>
                    </div>
                    <a href="{{ route('checkout') }}" class="checkout-btn">Thanh toán</a>
                </div>
            </div>
        </div>
    </section>
    @include('costumer.partials.popular-products')
@endsection