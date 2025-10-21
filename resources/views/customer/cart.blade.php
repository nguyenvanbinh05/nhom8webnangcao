@extends('customer.layouts.myapp')
@section('title', 'Giỏ hàng')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <section class="cart-section fade-in">
        <div class="main-content">
            <h2 class="cart-title">Giỏ hàng</h2>

            @if($items->isEmpty())
                <div class="cart-empty">
                    <p>🛒 Giỏ hàng trống</p>
                    <a href="{{ route('menu.index') }}" class="checkout-btn">Mua ngay</a>
                </div>
            @else
                <div class="cart-container">
                    <!-- DANH SÁCH SẢN PHẨM -->
                    <div class="cart-list">
                        @foreach ($items as $it)
                            <div class="cart-item" data-id="{{ $it->idCartItem }}">
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="idCartItem" value="{{ $it->idCartItem }}">
                                    <button class="remove-btn" title="Xóa" type="button">×</button>
                                </form>

                                <img src="{{ asset($it->product->MainImage ?: 'images/products/placeholder.svg') }}"
                                    alt="{{ $it->product->NameProduct }}">

                                <div class="cart-info">
                                    <a href="{{ route('product.show', $it->product->idProduct) }}" class="product-name">
                                        <h3>{{ $it->product->NameProduct }}</h3>
                                    </a>
                                    @if($it->size)
                                        <p class="size">{{ $it->size }}</p>
                                    @endif
                                    <p class="price">{{ number_format($it->price, 0, ',', '.') }}đ</p>
                                </div>

                                <div class="quantity-control">
                                    <form method="POST" action="{{ route('cart.update') }}">
                                        @csrf
                                        <input type="hidden" name="idCartItem" value="{{ $it->idCartItem }}">
                                        <button class="qty-decrease" type="button">-</button>
                                        <span class="qty-value">{{ $it->quantity }}</span>
                                        <button class="qty-increase" type="button">+</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- HÓA ĐƠN -->
                    <div class="cart-summary">
                        <h4>HẸN NGÀY THANH TOÁN</h4>
                        <label for="delivery-date">Ngày nhận hàng</label>
                        <input type="date" id="delivery-date" value="{{ now()->addDays(1)->toDateString() }}">
                        <div class="total">
                            <span>TỔNG CỘNG</span>
                            <strong
                                id="cart-total">{{ number_format($items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}đ</strong>
                        </div>
                        <a href="{{ route('checkout') }}" class="checkout-btn">Thanh toán</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('customer.partials.popular-products')
    <script>
        function csrf() {
            const m = document.querySelector('meta[name="csrf-token"]');
            return m ? m.getAttribute('content') : '';
        }
        function vnd(n) {
            return Number(n).toLocaleString('vi-VN') + 'đ';
        }

        document.addEventListener('click', async function (e) {
            // Tăng/giảm số lượng
            const incBtn = e.target.closest('.qty-increase');
            const decBtn = e.target.closest('.qty-decrease');
            const rmBtn = e.target.closest('.remove-btn');

            if (incBtn || decBtn) {
                const itemEl = e.target.closest('.cart-item');
                if (!itemEl) return;
                const id = itemEl.getAttribute('data-id');
                const action = incBtn ? 'increase' : 'decrease';

                try {
                    const res = await fetch("{{ route('cart.update') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf(), 'Accept': 'application/json' },
                        body: JSON.stringify({ idCartItem: Number(id), action })
                    });
                    const data = await res.json();
                    if (!data.ok) throw new Error('update failed');

                    // cập nhật số lượng hiển thị
                    const qtySpan = itemEl.querySelector('.qty-value');
                    if (qtySpan) qtySpan.textContent = data.quantity;

                    // cập nhật tổng tiền
                    const totalEl = document.getElementById('cart-total');
                    if (totalEl) totalEl.textContent = vnd(data.cartTotal);

                    // (tuỳ chọn) cập nhật badge giỏ hàng trên header
                    const badge = document.getElementById('cart-count');
                    if (badge && data.cartCount != null) badge.textContent = data.cartCount;

                } catch (err) {
                    console.error(err);
                    alert('Không thể cập nhật số lượng.');
                }
            }

            // Xoá item
            if (rmBtn) {
                const itemEl = rmBtn.closest('.cart-item');
                if (!itemEl) return;
                const id = itemEl.getAttribute('data-id');

                try {
                    const res = await fetch("{{ route('cart.remove') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf(), 'Accept': 'application/json' },
                        body: JSON.stringify({ idCartItem: Number(id) })
                    });
                    const data = await res.json();
                    if (!data.ok) throw new Error('remove failed');

                    // xoá khỏi DOM
                    itemEl.remove();

                    // cập nhật tổng + badge
                    const totalEl = document.getElementById('cart-total');
                    if (totalEl) totalEl.textContent = vnd(data.cartTotal);
                    const badge = document.getElementById('cart-count');
                    if (badge && data.cartCount != null) badge.textContent = data.cartCount;

                    // nếu giỏ trống -> thay container bằng khối "giỏ hàng trống"
                    if (data.empty) {
                        const container = document.querySelector('.cart-container');
                        if (container) {
                            container.outerHTML = `
                        <div class="cart-empty">
                          <p>🛒 Giỏ hàng trống</p>
                          <a href="{{ route('menu.index') }}" class="checkout-btn">Mua ngay</a>
                        </div>`;
                        }
                    }
                } catch (err) {
                    console.error(err);
                    alert('Không thể xoá sản phẩm.');
                }
            }
        });
    </script>

@endsection