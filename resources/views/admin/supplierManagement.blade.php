@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')

<div class="content_body">
    <div class="content__header">
        <!-- Action buttons -->
        <a href="#" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>

    </div>
    <!-- table content -->
    <table class="table">
        <thead class="table__head">
            <tr class="table__row">
                <th class="table__cell">STT</th>
                <th class="table__cell">Nhà cung cấp</th>
                <th class="table__cell">Số điện thoại</th>
                <th class="table__cell">Email</th>
                <th class="table__cell">Địa chỉ</th>
                <th class="table__cell">ghi chú</th>
                <th class="table__cell">Thao tác</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <tr class="table__row">
                <td class="table__cell">1</td>
                <td class="table__cell name">Công ty ABC</td>
                <td class="table__cell phone">0123456789</td>
                <td class="table__cell email">abc@example.com</td>
                <td class="table__cell address">Hà Nội</td>
                <td class="table__cell note">cung cấp nguyên liệu ... </td>
                <td class="table__cell actions-column">
                    <div class="action-item">
                        <button class="actions__btn buttonEditForm"><i
                                class="fa-solid fa-pen-to-square actions__icon"></i></button>
                        <button class="actions__btn"><i
                                class="fa-solid fa-trash actions__icon"></i></button>
                    </div>
                </td>
            </tr>
            <tr class="table__row">
                <td class="table__cell">2</td>
                <td class="table__cell">Công ty XYZ</td>
                <td class="table__cell">0987654321</td>
                <td class="table__cell">xyz@example.com</td>
                <td class="table__cell">Hồ Chí Minh</td>
                <td class="table__cell">cung cấp nguyên liệu ... </td>
                <td class="table__cell actions-column">
                    <div class="action-item">
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

@include('admin.supplierAdd')
@include('admin.supplierEdit')

@endsection