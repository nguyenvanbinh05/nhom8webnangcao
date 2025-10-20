@extends('costumer.layouts.myapp')
@section('title', $product->NameProduct)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
@endpush

@section('content')
    <section class="product-detail">
        <div class="main-content">

            {{-- Breadcrumb đơn giản --}}
            <nav class="breadcrumb">
                <a href="{{ route('menu.index') }}">Menu</a>
                <span>/</span>
                <a href="{{ route('menu.byCategory', $product->CategoryId) }}">{{ $product->category->NameCategory }}</a>
                <span>/</span>
                <span>{{ $product->NameProduct }}</span>
            </nav>

            <div class="product-detail__grid">
                {{-- Gallery --}}
                <div class="product-gallery">
                    <div class="product-gallery__main">
                        <img src="{{ asset($product->MainImage ?: 'images/products/placeholder.svg') }}"
                            alt="{{ $product->NameProduct }}">
                    </div>

                    @if($product->additationImages->isNotEmpty())
                        <div class="product-gallery__thumbs">
                            @foreach($product->additationImages as $img)
                                <img src="{{ asset($img->AdditationLink) }}" alt="Ảnh phụ">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="product-info">
                    <h1 class="product-title">{{ $product->NameProduct }}</h1>

                    {{-- Giá mặc định = size nhỏ nhất (nếu có). Nếu Tiramisu dùng size mặc định M trong seed, vẫn hiện đúng.
                    --}}
                    {{-- Giá hiện tại (theo size đang chọn) --}}
                    @php
                        $sortedSizes = $product->sizes->sortBy('Price');
                        $defaultSize = $sortedSizes->first(); // mặc định = size rẻ nhất
                    @endphp
                    <p class="product-price" id="pd-current-price">
                        @if($defaultSize)
                            {{ number_format($defaultSize->Price, 0, ',', '.') }}đ
                        @endif
                    </p>

                    {{-- Mô tả --}}
                    @if($product->Description)
                        <div class="product-desc">{!! nl2br(e($product->Description)) !!}</div>
                    @endif

                    {{-- Chọn size (nếu có nhiều) --}}
                    @if($product->sizes->isNotEmpty())
                        <div class="product-sizes" id="pd-sizes">
                            <span>Kích thước:</span>
                            <div class="size-list" id="pd-size-list">
                                @foreach($sortedSizes as $sz)
                                    {{--
                                    Dùng button (hoặc label + input) tuỳ CSS của bạn.
                                    Ở đây dùng button để đơn giản, có gán data-* để JS đọc.
                                    --}}
                                    <button type="button"
                                        class="size-item {{ $defaultSize && $defaultSize->idProductSize === $sz->idProductSize ? 'active' : '' }}"
                                        data-size="{{ $sz->Size }}" data-price="{{ $sz->Price }}">
                                        {{ $sz->Size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Trạng thái --}}
                    @if($product->Status === 'Stopped')
                        <div class="product-status out">Hết hàng</div>
                    @else
                        <div class="product-actions">
                            <button class="btn add-to-cart" data-product-id="{{ $product->idProduct }}">
                                Thêm vào giỏ
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sản phẩm liên quan --}}
            @if($related->isNotEmpty())
                <div class="related-products">
                    <h2>Sản phẩm liên quan</h2>
                    <div class="menu-products">
                        @foreach($related as $rp)
                            @php $rpMin = $rp->sizes->sortBy('Price')->first(); @endphp
                            <a href="{{ route('product.show', $rp->idProduct) }}" class="menu-card">
                                <div class="menu-card-img">
                                    <img src="{{ asset($rp->MainImage ?: 'images/products/placeholder.svg') }}"
                                        alt="{{ $rp->NameProduct }}">
                                </div>
                                <div class="menu-card-info">
                                    <p class="menu-card-name">{{ $rp->NameProduct }}</p>
                                    @if($rpMin)
                                        <p class="menu-card-price">{{ number_format($rpMin->Price, 0, ',', '.') }} đ</p>
                                    @endif
                                </div>
                                <button class="menu-card-cart" title="Thêm vào giỏ hàng" data-product-id="{{ $rp->idProduct }}">
                                    <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                                </button>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection