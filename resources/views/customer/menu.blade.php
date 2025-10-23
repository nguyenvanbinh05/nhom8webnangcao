@extends('customer.layouts.myapp')
@section('title', 'Menu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endpush

@section('content')
    <section class="menu-section fade-in">
        <div class="main-content menu-container">
            <!-- Sidebar -->
            <div class="menu-sidebar">
                <form method="GET" action="{{ $activeId ? route('menu.byCategory', $activeId) : route('menu.index') }}"
                    class="menu-search">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Tìm đồ uống..." />
                    <button type="submit">Tìm</button>
                </form>

                <ul>
                    <li>
                        <a href="{{ route('menu.index') }}" class="{{ $activeId ? '' : 'active' }}">Tất cả</a>
                    </li>
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('menu.byCategory', $cat->idCategory) }}"
                                class="{{ ($activeId === $cat->idCategory) ? 'active' : '' }}">
                                {{ $cat->NameCategory }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Nội dung -->
            <div class="menu-content" id="menu-content">
                @forelse ($grouped as $groupName => $items)
                    <div class="menu-group">
                        <h2>{{ $groupName }}</h2>
                        <div class="menu-products">
                            @forelse ($items as $product)
                                @php

                                    $hasLabeled = $product->sizes->whereNotNull('Size')->isNotEmpty();

                                    $minSize = $product->sizes->sortBy('Price')->first();

                                    $displayPrice = $minSize->Price ?? $product->Price;
                                @endphp

                                <div class="menu-card">

                                    <a href="{{ route('product.show', $product->idProduct) }}" class="menu-card-link"
                                        aria-label="Xem chi tiết">
                                        <div class="menu-card-img">
                                            <img src="{{ asset('storage/' . $product->MainImage) }}"
                                                alt="{{ $product->NameProduct }}">
                                        </div>

                                        <div class="menu-card-info">
                                            <p class="menu-card-name">{{ $product->NameProduct }}</p>

                                            @if(!is_null($displayPrice))
                                                <p class="menu-card-price">
                                                    {{ number_format($displayPrice, 0, ',', '.') }} đ
                                                </p>
                                            @endif

                                            @if($product->Status === 'Stopped')
                                                <small class="badge badge-out">Hết hàng</small>
                                            @endif
                                        </div>
                                    </a>

                                    <!-- Nút giỏ hàng -->
                                    @if($product->Status !== 'Stopped')
                                        @if(!$hasLabeled)
                                            <button class="menu-card-cart" title="Thêm vào giỏ hàng" type="button"
                                                data-product-id="{{ $product->idProduct }}">
                                                <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                                            </button>
                                        @else
                                            <a class="menu-card-cart" title="Chọn size"
                                                href="{{ route('product.show', $product->idProduct) }}">
                                                <img src="{{ asset('images/icons/cart.svg') }}" alt="Chọn size">
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            @empty
                                <p>Chưa có sản phẩm.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <p>Không có dữ liệu.</p>
                @endforelse
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="{{ asset('js/menu.js') }}"></script>
    @endpush
@endsection