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
            @forelse ($suppliers as $index => $supplier)
            <tr class="table__row">
                <td class="table__cell">{{ $index + 1 }}</td>
                <td class="table__cell name">{{ $supplier->name }}</td>
                <td class="table__cell phone">{{ $supplier->phone }}</td>
                <td class="table__cell email">{{ $supplier->email }}</td>
                <td class="table__cell address">{{ $supplier->address }}</td>
                <td class="table__cell note">{{ $supplier->note }}</td>
                <td class="table__cell actions-column">
                    <div class="action-item">
                        <button class="actions__btn buttonEditForm" data-id="{{ $supplier->id }}">
                            <i class="fa-solid fa-pen-to-square actions__icon"></i>
                        </button>
                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="actions__btn" type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                <i class="fa-solid fa-trash actions__icon"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="table__cell">Không có nhà cung cấp nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('admin.supplierViews.supplierAdd')
@include('admin.supplierViews.supplierEdit')

@endsection