@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')

<div class="content_body">
    <div class="content__header">
        <!-- Search -->
        <!-- <div class="search">
            <input type="text" class="search__input" placeholder="Tìm kiếm theo id, tên sản sản phẩm...">
            <button class="search__btn">
                <i class="fa-solid fa-magnifying-glass search__icon"></i>
            </button>
        </div> -->
        <!-- Action buttons -->
        <a href="{{ route('ingredients.create') }}" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>
    </div>
    <!-- table -->
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
                <th class="table__cell">Thao tác</th>
            </tr>
        </thead>
        <tbody class="table__body">
            @foreach($ingredients as $index => $ingredient)
            <tr class="table__row">
                <td>{{ $index + 1 }}</td>
                <td>{{ $ingredient->name }}</td>
                <td>{{ $ingredient->quantity }}</td>
                <td>{{ $ingredient->unit }}</td>
                <td>{{ $ingredient->supplier ? $ingredient->supplier->name : '' }}</td>
                <td>{{ $ingredient->import_date }}</td>
                <td>{{ $ingredient->expiry_date }}</td>
                <td class="table__cell actions">
                    <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="actions__btn">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="actions__btn" onclick="return confirm('Bạn có chắc muốn xóa?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection