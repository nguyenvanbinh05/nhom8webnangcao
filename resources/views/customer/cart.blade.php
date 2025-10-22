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
                                    <button class="remove-btn" title="Xóa" type="submit">×</button>
                                </form>

                                @php
                                    $imgUrl = $it->product->MainImage ? asset('storage/' . $it->product->MainImage) : null;
                                @endphp
                                @if($imgUrl)
                                    <img src="{{ $imgUrl }}" alt="{{ $it->product->NameProduct }}">
                                @endif

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
                                    <form method="POST" action="{{ route('cart.update') }}" class="quantity-control">
                                        @csrf
                                        <input type="hidden" name="idCartItem" value="{{ $it->idCartItem }}">
                                        <button name="action" value="decrease" class="qty-decrease" type="button">-</button>
                                        <span class="qty-value">{{ $it->quantity }}</span>
                                        <button name="action" value="increase" class="qty-increase" type="button">+</button>
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
        (() => {
            const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
            const vnd = n => Number(n).toLocaleString('vi-VN') + 'đ';
            const post = (url, data) => fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(r => r.json());

            document.addEventListener('click', async (e) => {
                const inc = e.target.closest('.qty-increase');
                const dec = e.target.closest('.qty-decrease');
                const rm = e.target.closest('.remove-btn');
                if (!inc && !dec && !rm) return;
                e.preventDefault();

                const item = e.target.closest('.cart-item'); if (!item) return;
                const id = Number(item.dataset.id);

                try {
                    if (inc || dec) {
                        const data = await post("{{ route('cart.update') }}", { idCartItem: id, action: inc ? 'increase' : 'decrease' });
                        if (!data.ok) throw 0;
                        item.querySelector('.qty-value').textContent = data.quantity;
                        const total = document.getElementById('cart-total'); if (total) total.textContent = vnd(data.cartTotal);
                        const badge = document.getElementById('cart-count'); if (badge && data.cartCount != null) badge.textContent = data.cartCount;
                    } else if (rm) {
                        const data = await post("{{ route('cart.remove') }}", { idCartItem: id });
                        if (!data.ok) throw 0;
                        item.remove();
                        const total = document.getElementById('cart-total'); if (total) total.textContent = vnd(data.cartTotal);
                        const badge = document.getElementById('cart-count'); if (badge && data.cartCount != null) badge.textContent = data.cartCount;
                        if (data.empty) {
                            const wrap = document.querySelector('.cart-container');
                            if (wrap) wrap.outerHTML = `<div class="cart-empty"><p>🛒 Giỏ hàng trống</p><a href="{{ route('menu.index') }}" class="checkout-btn">Mua ngay</a></div>`;
                        }
                    }
                } catch {
                    alert('Có lỗi khi cập nhật giỏ hàng.');
                }
            });
        })();
    </script>
@endsection