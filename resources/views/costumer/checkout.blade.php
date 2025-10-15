@extends('costumer.layouts.myapp')
@section('title', 'Thanh toán')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush
@section('content')

    <section class="checkout-section">
        <div class="checkout-grid">

            <!-- LEFT: THÔNG TIN GIAO HÀNG -->
            <form class="checkout-form" autocomplete="on">
                <h2>Thông tin giao hàng</h2>

                <div class="grid-2">
                    <div class="field">
                        <label for="name">Họ và tên</label>
                        <input id="name" type="text" placeholder="Họ và tên">
                    </div>
                    <div class="field">
                        <label for="phone">Số điện thoại</label>
                        <input id="phone" type="tel" placeholder="Số điện thoại">
                    </div>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" placeholder="Email">
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label for="province">Tỉnh/Thành</label>
                        <select id="province">
                            <option>Chọn Tỉnh/Thành</option>
                            <option>Hà Nội</option>
                            <option>TP. Hồ Chí Minh</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="district">Quận/Huyện</label>
                        <select id="district">
                            <option>Chọn Quận/Huyện</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="address">Địa chỉ chi tiết</label>
                    <input id="address" type="text" placeholder="Số nhà, đường, phường/xã…">
                </div>

                <div class="field">
                    <label for="note">Ghi chú</label>
                    <textarea id="note" rows="3" placeholder="Ghi chú"></textarea>
                </div>

                <h3>Hình thức thanh toán</h3>
                <div class="payment-method">
                    <label class="pay-option">
                        <input type="radio" name="payment" checked>
                        <span class="icon">💵</span>
                        <span>Thanh toán khi nhận hàng (COD)</span>
                    </label>
                </div>

                <div class="actions">
                    <a class="btn-outline" href="/gio-hang">
                        < Giỏ hàng</a>
                            <button class="btn-primary" type="submit">Thanh toán</button>
                </div>
            </form>

            <!-- RIGHT: TÓM TẮT ĐƠN HÀNG -->
            <aside class="checkout-summary">
                <ul class="cart-list">
                    <!-- item -->
                    <li class="cart-item">
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                        <div class="info">
                            <a href="#" class="name">Cà phê đen</a>
                            <div class="meta">Size S</div>
                        </div>
                        <div class="price">55.000đ</div>
                    </li>

                    <li class="cart-item">
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                        <div class="info">
                            <a href="#" class="name">Cà phê đen</a>
                            <div class="meta">Size S</div>
                        </div>
                        <div class="price">55.000đ</div>
                    </li>

                    <li class="cart-item">
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                        <div class="info">
                            <a href="#" class="name">Cà phê đen</a>
                            <div class="meta">Size S</div>
                        </div>
                        <div class="price">55.000đ</div>
                    </li>

                    <li class="cart-item">
                        <img src="{{ asset('images/products/capheden.svg') }}" alt="Cà phê đen">
                        <div class="info">
                            <a href="#" class="name">Cà phê đen</a>
                            <div class="meta">Size S</div>
                        </div>
                        <div class="price">55.000đ</div>
                    </li>
                </ul>

                <div class="totals">
                    <div class="row"><span>Tạm tính:</span><span>5.000.000đ</span></div>
                    <div class="row"><span>Phí ship:</span><span>Miễn phí</span></div>
                    <div class="grand">
                        <span>Tổng cộng</span>
                        <span class="grand-price">5.000.000đ</span>
                    </div>
                </div>
            </aside>
        </div>
    </section>

@endsection