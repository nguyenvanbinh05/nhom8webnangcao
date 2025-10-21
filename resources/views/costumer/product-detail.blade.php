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
                        <img id="pd-main-image" src="{{ asset($thumbs->first() ?? 'images/products/placeholder.svg') }}"
                            alt="{{ $product->NameProduct }}">
                    </div>
                    <div class="thumb-list" id="pd-thumbs">
                        @foreach($thumbs as $i => $src)
                            <img class="{{ $i === 0 ? 'active' : '' }}" src="{{ asset($src) }}" data-src="{{ asset($src) }}"
                                alt="thumb-{{ $i + 1 }}">
                        @endforeach
                    </div>
                </div>

                <!-- Cột phải: thông tin sản phẩm -->
                <div class="product-info">
                    <h1 class="product-title">{{ $product->NameProduct }}</h1>
                    <p class="product-status">Tình trạng:
                        <strong class="{{ $product->Status === 'Stopped' ? 'text-out' : 'text-in' }}">
                            {{ $product->Status === 'Stopped' ? 'Hết hàng' : 'Còn hàng' }}
                        </strong>
                    </p>

                    <div class="product-price">
                        <span class="price-current">
                            @if($currentPrice) {{ number_format($currentPrice, 0, ',', '.') }}đ
                            @endif
                        </span>
                        <span class="price-old">60.000đ</span>
                    </div>

                    @if($hasLabeled)
                        <div class="product-sizes">
                            <span>Kích thước:</span>
                            <div id="pd-size-list" class="sizes">
                                @foreach($sizesSorted as $sz)
                                    @continue(is_null($sz->Size))
                                    <button type="button" data-role="size" data-size="{{ $sz->Size }}" data-price="{{ $sz->Price }}"
                                        class="{{ $loop->first ? 'active' : '' }} size">
                                        {{ $sz->Size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="product-quantity">
                        <label for="quantity">Số lượng:</label>
                        <div class="quantity-box">
                            <input id="quantity" type="number" value="1" min="1">
                        </div>
                    </div>


                    <div class="product-action">
                        <button class="btn-buy" data-product-id="{{ $product->idProduct }}">Mua ngay</button>
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->idProduct }}">
                            <input type="hidden" name="size" id="pd-size-input">
                            <input type="hidden" name="quantity" id="pd-qty-input" value="1">
                            <button class="btn-add">Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mô tả sản phẩm -->
            @if($product->Description)
                <div class="product-description">
                    <h2>Mô tả sản phẩm</h2>
                    {!! nl2br(e($product->Description)) !!}
                </div>
            @endif
            <!-- SẢN PHẨM CÙNG LOẠI -->
            @if($related->isNotEmpty())
                <div class="related-products">
                    <div class="title">
                        <h2>Sản Phẩm Cùng Loại</h2>
                    </div>

                    <div class="main-content">
                        <div class="related-list">
                            @foreach ($related as $rp)
                                @php
                                    $img = $rp->MainImage ?: 'images/products/placeholder.svg';
                                    $rpMin = $rp->sizes->sortBy('Price')->first(); // giá nhỏ nhất (kể cả size NULL)
                                @endphp

                                <div class="related-card">
                                    <div class="related-image">
                                        <a href="{{ route('product.show', $rp->idProduct) }}">
                                            <img src="{{ asset($img) }}" alt="{{ $rp->NameProduct }}">
                                        </a>
                                    </div>

                                    <div class="related-info">
                                        <a href="{{ route('product.show', $rp->idProduct) }}" class="related-name">
                                            {{ $rp->NameProduct }}
                                        </a>

                                        @if($rpMin)
                                            <p class="related-price">{{ number_format($rpMin->Price, 0, ',', '.') }} đ</p>
                                        @else
                                            <p class="related-price">—</p>
                                        @endif
                                    </div>

                                    <button class="related-cart-btn" title="Thêm vào giỏ hàng"
                                        data-product-id="{{ $rp->idProduct }}" @if($rp->Status === 'Stopped') disabled @endif>
                                        <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ---------- THUMBNAILS → ẢNH LỚN ----------
            const mainImg = document.getElementById('pd-main-image');
            const thumbs = document.getElementById('pd-thumbs');
            if (mainImg && thumbs) {
                thumbs.addEventListener('click', function (e) {
                    const t = e.target.closest('img');
                    if (!t) return;

                    thumbs.querySelectorAll('img.active').forEach(x => x.classList.remove('active'));
                    t.classList.add('active');

                    const src = t.dataset.src || t.getAttribute('src');
                    if (src) mainImg.setAttribute('src', src);
                });
            }

            // ---------- SIZE → CẬP NHẬT GIÁ + HIDDEN INPUT ----------
            const priceEl = document.querySelector('.price-current');           // nơi hiển thị giá
            const sizeWrap = document.getElementById('pd-size-list');            // container các nút size
            const sizeInput = document.getElementById('pd-size-input');           // <input type="hidden" name="size">
            const qtyInput = document.getElementById('pd-qty-input');            // <input type="hidden" name="quantity">
            const qtyBox = document.getElementById('quantity');                // input số lượng hiển thị

            // đồng bộ số lượng hiển thị -> hidden (nếu có)
            if (qtyBox && qtyInput) {
                const syncQty = () => {
                    const val = Math.max(1, parseInt(qtyBox.value || '1', 10));
                    qtyBox.value = val;
                    qtyInput.value = val;
                };
                syncQty();
                qtyBox.addEventListener('change', syncQty);
                qtyBox.addEventListener('input', syncQty);
            }

            // click chọn size
            if (priceEl && sizeWrap) {
                sizeWrap.addEventListener('click', function (e) {
                    const btn = e.target.closest('[data-role="size"]');
                    if (!btn) return;
                    e.preventDefault(); // tránh submit form nếu nút nằm trong <form>

                    // toggle active
                    sizeWrap.querySelectorAll('[data-role="size"].active').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    // cập nhật giá hiển thị
                    const raw = btn.dataset.price;
                    if (raw) {
                        priceEl.textContent = Number(raw).toLocaleString('vi-VN') + 'đ';
                        priceEl.dataset.currentPrice = raw; // lưu cho mục đích khác (nếu cần)
                    }

                    // cập nhật hidden size (nếu có)
                    if (sizeInput) sizeInput.value = btn.dataset.size || '';
                });

                // set giá & hidden size ban đầu theo nút đang active (nếu có)
                const initBtn = sizeWrap.querySelector('[data-role="size"].active') ||
                    sizeWrap.querySelector('[data-role="size"]');
                if (initBtn) {
                    if (sizeInput) sizeInput.value = initBtn.dataset.size || '';
                    const raw = initBtn.dataset.price;
                    if (raw) priceEl.textContent = Number(raw).toLocaleString('vi-VN') + 'đ';
                }
            }
        });
    </script>


@endsection