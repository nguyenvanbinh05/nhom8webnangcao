@extends('layouts.layout_management')

@section('titlepage', 'Coffee')

@section('content')

<div class="content__body">
    <div class="content__header">
        <!-- Search -->
        <!-- <div class="search">
            <input type="text" class="search__input" placeholder="Tìm kiếm theo id, tên sản sản phẩm...">
            <button class="search__btn">
                <i class="fa-solid fa-magnifying-glass search__icon"></i>
            </button>
        </div> -->
        <!-- Action buttons -->
        <a href="#" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>
    </div>
    <!-- list account -->
    <div class="account-role">
        <h2 class="account-role__label">Admin</h2>
        <!-- table -->
        <table class="table">
            <thead class="table__head">
                <tr class="table__row">
                    <th class="table__cell">STT</th>
                    <th class="table__cell">Tên</th>
                    <th class="table__cell">Số điện thoại</th>
                    <th class="table__cell">Email</th>
                    <th class="table__cell">Ngày tạo</th>
                    <th class="table__cell">Trạng thái</th>
                    <th class="table__cell">Hành động</th>
                </tr>
            </thead>
            <tbody class="table__body">
                <tr class="table__row">
                    <td class="table__cell">1</td>
                    <td class="table__cell">Nguyễn Văn A</td>
                    <td class="table__cell">0901234567</td>
                    <td class="table__cell">a.admin@example.com</td>
                    <td class="table__cell">2025-01-10</td>
                    <td class="table__cell">Kích hoạt</td>
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
    <div class="account-role">
        <!-- Nhân viên -->
        <h2 class="account-role__label">Nhân viên</h2>
        <table class="table">
            <thead class="table__head">
                <tr class="table__row">
                    <th class="table__cell">STT</th>
                    <th class="table__cell">Tên</th>
                    <th class="table__cell">Số điện thoại</th>
                    <th class="table__cell">Email</th>
                    <th class="table__cell">Ngày tạo</th>
                    <th class="table__cell">Trạng thái</th>
                    <th class="table__cell">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table__row">
                    <td class="table__cell">1</td>
                    <td class="table__cell">Trần Thị B</td>
                    <td class="table__cell">0912345678</td>
                    <td class="table__cell">b.staff@example.com</td>
                    <td class="table__cell">2025-02-12</td>
                    <td class="table__cell">kích hoạt</td>
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

    <div class="account-role">
        <h2 class="account-role__label">Khách hàng</h2>
        <table class="table">
            <thead class="table__head">
                <tr class="table__row">
                    <th class="table__cell">STT</th>
                    <th class="table__cell">Tên</th>
                    <th class="table__cell">Số điện thoại</th>
                    <th class="table__cell">Email</th>
                    <th class="table__cell">Ngày tạo</th>
                    <th class="table__cell">Trạng thái</th>
                    <th class="table__cell">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table__row">
                    <td class="table__cell">1</td>
                    <td class="table__cell">Lê Văn C</td>
                    <td class="table__cell">0987654321</td>
                    <td class="table__cell">c.customer@example.com</td>
                    <td class="table__cell">2025-03-05</td>
                    <td class="table__cell">Vô hiệu hóa</td>
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
</div>

@endsection