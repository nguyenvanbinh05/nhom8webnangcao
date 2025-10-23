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
                    <th class="table__cell">Hành động</th>
                </tr>
            </thead>
            <tbody class="table__body">
                @foreach ($admins as $index => $admin)
                <tr class="table__row">
                    <td class="table__cell">{{ $index + 1 }}</td>
                    <td class="table__cell">{{ $admin->name }}</td>
                    <td class="table__cell">{{ $admin->phone }}</td>
                    <td class="table__cell">{{ $admin->email }}</td>
                    <td class="table__cell actions-column">
                        <div class="action-item">
                            <button class="actions__btn"><i
                                    class="fa-solid fa-pen-to-square actions__icon"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
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
                    <!-- <th class="table__cell">Trạng thái</th> -->
                    <th class="table__cell">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staffs as $index => $staff)
                <tr class="table__row">
                    <td class="table__cell">{{ $index + 1 }}</td>
                    <td class="table__cell">{{ $staff->name }}</td>
                    <td class="table__cell">{{ $staff->phone }}</td>
                    <td class="table__cell">{{ $staff->email }}</td>
                    <td class="table__cell">{{ $staff->created_at->format('Y-m-d') }}</td>
                    <!-- <td class="table__cell">{{ $staff->status === 'active' ? 'Kích hoạt' : 'Vô hiệu hóa' }}</td> -->
                    <td class="table__cell actions-column">
                        <div class="action-item">
                            <button class="actions__btn"><i
                                    class="fa-regular fa-eye actions__icon"></i></button>
                            <button class="actions__btn"><i
                                    class="fa-solid fa-pen-to-square actions__icon"></i></button>
                            <form action="{{ route('accounts.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="actions__btn"><i
                                        class="fa-solid fa-trash actions__icon"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Không có nhân viên nào.</td>
                </tr>
                @endforelse
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
                    <!-- <th class="table__cell">Trạng thái</th> -->
                    <th class="table__cell">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $index => $customer)
                <tr class="table__row">
                    <td class="table__cell">{{ $index + 1 }}</td>
                    <td class="table__cell">{{ $customer->name }}</td>
                    <td class="table__cell">{{ $customer->phone }}</td>
                    <td class="table__cell">{{ $customer->email }}</td>
                    <td class="table__cell">{{ $customer->created_at->format('Y-m-d') }}</td>
                    <!-- <td class="table__cell">{{ $customer->status === 'active' ? 'Kích hoạt' : 'Vô hiệu hóa' }}</td> -->
                    <td class="table__cell actions-column">
                        <div class="action-item">
                            <button class="actions__btn"><i
                                    class="fa-regular fa-eye actions__icon"></i></button>
                            <a href="#"
                                class="actions__btn buttonEditForm"
                                data-route="{{ route('accounts.update', $customer->id) }}"
                                data-id="{{ $customer->id }}"
                                data-name="{{ $customer->name }}"
                                data-email="{{ $customer->email }}"
                                data-phone="{{ $customer->phone }}"
                                data-role="{{ $customer->role }}">
                                <i class="fa-solid fa-pen-to-square actions__icon"></i>
                            </a>

                            <form action="{{ route('accounts.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="actions__btn"><i
                                        class="fa-solid fa-trash actions__icon"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Không có khách hàng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin.accountViews.accountAdd')
@include('admin.accountViews.accountEdit')

@endsection