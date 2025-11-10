@extends('layouts.layout_management')

@section('titlepage', 'Quản lý tài khoản')

@section('content')
<div class="content__body">
    <div class="content__header">
        <!-- Search -->
        <div class="search-wrapper" style="display: flex; gap: 20px; align-items: center;">
            <form action="{{ route('accounts.index') }}" method="GET" style="flex: 1; display: flex; gap: 20px;">
                <div class="search">
                    <input type="text"
                        class="search__input"
                        name="search"
                        placeholder="Tìm kiếm theo tên, email,..."
                        value="{{ $search ?? '' }}">
                    <button type="submit" class="search__btn">
                        <i class="fa-solid fa-magnifying-glass search__icon"></i>
                    </button>
                </div>
                <select name="role"
                    class="search__input"
                    style="padding: 8px; border: 1px solid #ccc; border-radius: 10px;">
                    <option value="">-- Chọn vai trò --</option>
                    <option value="" {{ !isset($role) || $role=='' ? 'selected' : '' }}>Tất cả</option>
                    <option value="admin" {{ (isset($role) && $role=='admin') ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ (isset($role) && $role=='staff') ? 'selected' : '' }}>Nhân viên</option>
                    <option value="customer" {{ (isset($role) && $role=='customer') ? 'selected' : '' }}>Khách hàng</option>
                </select>

                <button type="submit" class="search__btn"
                    style="padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    <i class="fa-solid fa-magnifying-glass search__icon"></i>
                </button>
            </form>
        </div>

        <a href="#" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>
    </div>

    <div class="account-role">
        <table class="table">
            <thead class="table__head">
                <tr class="table__row">
                    <th class="table__cell">STT</th>
                    <th class="table__cell">Tên</th>
                    <th class="table__cell">Số điện thoại</th>
                    <th class="table__cell">Email</th>
                    <th class="table__cell">Vai trò</th>
                    <th class="table__cell">Trạng thái</th>
                    <th class="table__cell">Ngày tạo</th>
                    <th class="table__cell">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($accounts as $index => $account)
                <tr class="table__row">
                    <td class="table__cell">{{ $index + 1 }}</td>
                    <td class="table__cell">{{ $account->name }}</td>
                    <td class="table__cell">{{ $account->phone }}</td>
                    <td class="table__cell">{{ $account->email }}</td>
                    <td class="table__cell">{{ ucfirst($account->role) }}</td>
                    <td class="table__cell">
                        {{ $account->status === 'active' ? 'Hoạt động' : 'Ngừng hoạt động' }}
                    </td>
                    <td class="table__cell">{{ $account->created_at->format('Y-m-d') }}</td>
                    <td class="table__cell actions-column">
                        <div class="action-item">

                            <a href="#"
                                class="actions__btn buttonEditForm"
                                data-route="{{ route('accounts.update', $account->id) }}"
                                data-id="{{ $account->id }}"
                                data-name="{{ $account->name }}"
                                data-email="{{ $account->email }}"
                                data-phone="{{ $account->phone }}"
                                data-role="{{ $account->role }}"
                                data-status="{{ $account->status }}">
                                <i class="fa-solid fa-pen-to-square actions__icon"></i>
                            </a>

                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="actions__btn">
                                    <i class="fa-solid fa-trash actions__icon"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Không có tài khoản nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin.accountViews.accountAdd')
@include('admin.accountViews.accountEdit')

@endsection