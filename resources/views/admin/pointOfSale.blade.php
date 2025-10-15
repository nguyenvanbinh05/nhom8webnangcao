@extends('layouts.layout_management')

@section('content')

<!-- <div id="btnAddBill">
    <button class="button-add">
        <i class="fa-solid fa-plus"></i>
        <span>Thêm mới</span>
    </button>
</div> -->

<!-- Layout POS -->
<div class="pos__layout">
    <div class="pos__product">
        <div class="pos__option">
            <!-- Search -->
            <div class="search">
                <input type="text" class="search__input" placeholder="Tìm kiếm theo id, tên sản sản phẩm...">
                <button class="search__btn">
                    <i class="fa-solid fa-magnifying-glass search__icon"></i>
                </button>
            </div>
        </div>
        <!-- Danh sách sản phẩm -->
        <div class="pos__product-grid-container">
            <div class="pos__product-grid">
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
                <div class="pos__product-card">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Tên sản phẩm" class="pos__product-image">
                </div>
            </div>
        </div>
    </div>

    <!-- Panel thanh toán -->
    <div class="checkout">
        <div class="checkout__header">
            Hóa đơn thanh toán
        </div>

        <!-- Danh sách sản phẩm trong hóa đơn -->
        <div class="checkout__invoice-list">
            <div class="checkout__invoice-item">
                <div class="checkout__item-img">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Sản phẩm" class="checkout__item-image">
                </div>
                <div class="checkout__item-details">
                    <div class="checkout__item-infomation">
                        <span class="checkout__item-name">Tên sản phẩm</span>
                        <span class="checkout__item-price">50.000Đ</span>
                    </div>
                    <div class="checkout__item-quantity-price">
                        <div class="checkout__quantity-control">
                            <button class="checkout__qty-btn">-</button>
                            <input type="number" class="checkout__qty-input" value="1" min="1">
                            <button class="checkout__qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout__invoice-item">
                <div class="checkout__item-img">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Sản phẩm" class="checkout__item-image">
                </div>
                <div class="checkout__item-details">
                    <div class="checkout__item-infomation">
                        <span class="checkout__item-name">Tên sản phẩm</span>
                        <span class="checkout__item-price">50.000Đ</span>
                    </div>
                    <div class="checkout__item-quantity-price">
                        <div class="checkout__quantity-control">
                            <button class="checkout__qty-btn">-</button>
                            <input type="number" class="checkout__qty-input" value="1" min="1">
                            <button class="checkout__qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout__invoice-item">
                <div class="checkout__item-img">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Sản phẩm" class="checkout__item-image">
                </div>
                <div class="checkout__item-details">
                    <div class="checkout__item-infomation">
                        <span class="checkout__item-name">Tên sản phẩm</span>
                        <span class="checkout__item-price">50.000Đ</span>
                    </div>
                    <div class="checkout__item-quantity-price">
                        <div class="checkout__quantity-control">
                            <button class="checkout__qty-btn">-</button>
                            <input type="number" class="checkout__qty-input" value="1" min="1">
                            <button class="checkout__qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout__invoice-item">
                <div class="checkout__item-img">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Sản phẩm" class="checkout__item-image">
                </div>
                <div class="checkout__item-details">
                    <div class="checkout__item-infomation">
                        <span class="checkout__item-name">Tên sản phẩm</span>
                        <span class="checkout__item-price">50.000Đ</span>
                    </div>
                    <div class="checkout__item-quantity-price">
                        <div class="checkout__quantity-control">
                            <button class="checkout__qty-btn">-</button>
                            <input type="number" class="checkout__qty-input" value="1" min="1">
                            <button class="checkout__qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout__invoice-item">
                <div class="checkout__item-img">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Sản phẩm" class="checkout__item-image">
                </div>
                <div class="checkout__item-details">
                    <div class="checkout__item-infomation">
                        <span class="checkout__item-name">Tên sản phẩm</span>
                        <span class="checkout__item-price">50.000Đ</span>
                    </div>
                    <div class="checkout__item-quantity-price">
                        <div class="checkout__quantity-control">
                            <button class="checkout__qty-btn">-</button>
                            <input type="number" class="checkout__qty-input" value="1" min="1">
                            <button class="checkout__qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout__invoice-item">
                <div class="checkout__item-img">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Sản phẩm" class="checkout__item-image">
                </div>
                <div class="checkout__item-details">
                    <div class="checkout__item-infomation">
                        <span class="checkout__item-name">Tên sản phẩm</span>
                        <span class="checkout__item-price">50.000Đ</span>
                    </div>
                    <div class="checkout__item-quantity-price">
                        <div class="checkout__quantity-control">
                            <button class="checkout__qty-btn">-</button>
                            <input type="number" class="checkout__qty-input" value="1" min="1">
                            <button class="checkout__qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout__invoice-item">
                <div class="checkout__item-img">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Sản phẩm" class="checkout__item-image">
                </div>
                <div class="checkout__item-details">
                    <div class="checkout__item-infomation">
                        <span class="checkout__item-name">Tên sản phẩm</span>
                        <span class="checkout__item-price">50.000Đ</span>
                    </div>
                    <div class="checkout__item-quantity-price">
                        <div class="checkout__quantity-control">
                            <button class="checkout__qty-btn">-</button>
                            <input type="number" class="checkout__qty-input" value="1" min="1">
                            <button class="checkout__qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tóm tắt hóa đơn -->
        <div class="checkout__summary">
            <div class="checkout__summary-row">
                <span class="checkout__label">Tạm tính:</span>
                <span class="checkout__value">150.000Đ</span>
            </div>
            <div class="checkout__summary-row">
                <span class="checkout__label">Phí ship:</span>
                <span class="checkout__value">0Đ</span>
            </div>
            <div class="checkout__summary-row checkout__summary-row--total">
                <span class="checkout__label">Tổng tiền:</span>
                <span class="checkout__value">150.000Đ</span>
            </div>
        </div>

        <!-- Hình thức thanh toán -->
        <div class="checkout__payment">
            <div class="checkout__payment-header">Hình thức thanh toán:</div>

            <label class="checkout__payment-option">
                <input type="radio" name="payment" value="cash" checked>
                Thanh toán tiền mặt
            </label>

            <label class="checkout__payment-option">
                <input type="radio" name="payment" value="bank">
                Thanh toán qua ngân hàng
            </label>
        </div>

        <!-- Hành động -->
        <div class="checkout__action">
            <button class="checkout__pay-btn">Thanh toán</button>
        </div>
    </div>
</div>


@endsection