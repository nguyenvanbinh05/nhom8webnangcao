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
                <form method="GET" action="{{ $activeId ? route('menu.byCategory', $activeId) : route('menu.index') }}"
                    class="menu-search">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Tìm đồ uống..." />
                    <button type="submit">Tìm</button>
                </form>

                <ul>
                    <li><a href="{{ route('menu.index') }}" class="{{ $activeId ? '' : 'active' }}">Tất cả</a></li>
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
            <div class="menu-content">
                {{-- <div class="menu-group">
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
            </div> --}}
            @forelse ($grouped as $groupName => $items)
                <div class="menu-group">
                    <h2>{{ $groupName }}</h2>
                    <div class="menu-products">
                        @forelse ($items as $product)
                            <a href="{{ route('product.show', $product->idProduct) }}" class="menu-card">
                                <div class="menu-card-img">
                                    <img src="{{ asset($product->MainImage ?: 'images/products/placeholder.svg') }}"
                                        alt="{{ $product->NameProduct }}">
                                </div>

                                <div class="menu-card-info">
                                    <p class="menu-card-name">{{ $product->NameProduct }}</p>

                                    @php
                                        $minSize = $product->sizes->sortBy('Price')->first();
                                    @endphp

                                    @if($minSize)
                                        <p class="menu-card-price">{{ number_format($minSize->Price, 0, ',', '.') }} đ</p>
                                    @endif

                                    @if($product->Status === 'Stopped')
                                        <small class="badge badge-out">Hết hàng</small>
                                    @endif
                                </div>

                                <button class="menu-card-cart" title="Thêm vào giỏ hàng" data-product-id="{{ $product->idProduct }}"
                                    @if($product->Status === 'Stopped') disabled @endif>
                                    <img src="{{ asset('images/icons/cart.svg') }}" alt="Thêm vào giỏ">
                                </button>
                            </a>
                        @empty
                            <p>Chưa có sản phẩm.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <p>Không có dữ liệu.</p>
            @endforelse

            @if ($paginator->hasPages())
                <div class="menu-pagination">
                    {{ $paginator->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection