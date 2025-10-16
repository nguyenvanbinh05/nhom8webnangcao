@extends('layouts.layout_management')

@section('titlepage', 'coffee')


@section('content')
<div class="content__body">
    <div class="content__header">
        <!-- Action buttons -->
        <a href="{{ route('productAdd') }}" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>

    </div>

    <!-- Table -->
    <table class="table">
        <thead class="table__head">
            <tr class="table__row">
                <th class="table__cell">ID</th>
                <th class="table__cell">Sản phẩm</th>
                <th class="table__cell">Loại</th>
                <th class="table__cell">Giá</th>
                <th class="table__cell">Ngày thêm</th>
                <th class="table__cell">Trạng thái</th>
                <th class="table__cell">Thao tác</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <tr class="table__row">
                <td class="table__cell id">1</td>
                <td class="table__cell productInfo">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Product 1" class="order__img">
                    <div class="productInfo__details">
                        <span class="productInfo__id">O21231</span>
                        <span class="productInfo__name">Cà phê đen đá</span>
                    </div>
                </td>
                <td class="table__cell">Cà phê</td>
                <td class="table__cell">27.000đ</td>
                <td class="table__cell">26/09/2025</td>
                <td class="table__cell"><span class="status status--shipping">sẵn sàng</span></td>
                <td class="table__cell actions-column">
                    <div class="action-item">
                        <button class="actions__btn"><i
                                class="fa-regular fa-eye actions__icon"></i></button>
                        <button class="actions__btn"><i
                                class="fa-solid fa-pen-to-square actions__icon"></i></button>
                        <button class="actions__btn"><i
                                class="fa-solid fa-trash actions__icon"></i></button>
                    </div>
                </td>
            </tr>
            <tr class="table__row">
                <td class="table__cell id">1</td>
                <td class="table__cell productInfo">
                    <img src="{{ asset('images/san_pham.jpg') }}" alt="Product 1" class="order__img">
                    <div class="productInfo__details">
                        <span class="productInfo__id">O21231</span>
                        <span class="productInfo__name">Cà phê đen đá</span>
                    </div>
                </td>
                <td class="table__cell">Cà phê</td>
                <td class="table__cell">27.000đ</td>
                <td class="table__cell">26/09/2025</td>
                <td class="table__cell"><span class="status status--shipping">sẵn sàng</span></td>
                <td class="table__cell actions-column">
                    <div class="action-item">
                        <button class="actions__btn"><i
                                class="fa-regular fa-eye actions__icon"></i></button>
                        <button class="actions__btn"><i
                                class="fa-solid fa-pen-to-square actions__icon"></i></button>
                        <button class="actions__btn"><i
                                class="fa-solid fa-trash actions__icon"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection