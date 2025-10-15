@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')

<div class="content_body">
    <table class="table">
        <thead class="table__head">
            <tr class="table__row">
                <th class="table__cell">STT</th>
                <th class="table__cell">Tên nguyên liệu</th>
                <th class="table__cell">Số lượng</th>
                <th class="table__cell">Đơn vị</th>
                <th class="table__cell">Nhà cung cấp</th>
                <th class="table__cell">ngày nhập</th>
                <th class="table__cell">Hạn sử dụng</th>
                <th class="table__cell">Trạng thái</th>
                <th class="table__cell">Thao tác</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <tr class="table__row">
                <td class="table__cell">1</td>
                <td class="table__cell order">Trà đen</td>
                <td class="table__cell">10</td>
                <td class="table__cell">kg</td>
                <td class="table__cell">ABC Co</td>
                <td class="table__cell">1/1/2025</td>
                <td class="table__cell">30/12/2025</td>
                <td class="table__cell"><span class="status status--success">Sẵn sàng</span></td>
                <td class="table__cell actions">
                    <button class="actions__btn"><i class="fa-solid fa-pen-to-square actions__icon"></i></button>
                    <button class="actions__btn"><i class="fa-solid fa-trash actions__icon"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection