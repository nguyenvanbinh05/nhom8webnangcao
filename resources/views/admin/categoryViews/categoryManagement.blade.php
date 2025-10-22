@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')
<div class="content__body">
    <div class="content__header">
        <!-- Action buttons -->
        <a href="{{ route('category.create') }}" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>

    </div>

    <!-- Table -->
    <table class="table">
        <thead class="table__head">
            <tr class="table__row">
                <th class="table__cell">Stt</th>
                <th class="table__cell">Tên danh mục</th>
                <th class="table__cell">Mô tả ngắn</th>
                <th class="table__cell">Số lượng sản phẩm</th>
                <th class="table__cell">Trạng thái</th>
                <th class="table__cell">Hành động</th>
            </tr>
        </thead>
        <tbody class="table__body">
            @foreach ($categories as $index => $category)
            <tr class="table__row">
                <td class="table__cell">{{$index + 1}}</td>
                <td class="table__cell order">{{ $category->NameCategory }}</td>
                <td class="table__cell">{{ $category->Description }}</td>
                <td class="table__cell">{{ $category->products_count ?? 0 }}</td>
                <td class="table__cell">
                    @if ($category->Status === 'Available')
                    <span class="status status--success">Sẵn sàng</span>
                    @else
                    <span class="status status--warning">Tạm ngưng</span>
                    @endif
                </td>
                <td class="table__cell actions">
                    <a href="#"
                        class="actions__btn buttonEditForm"
                        data-route="{{ route('category.update', $category->idCategory) }}"
                        data-id="{{ $category->idCategory }}"
                        data-name="{{ $category->NameCategory }}"
                        data-desc="{{ $category->Description }}"
                        data-status="{{ $category->Status }}">
                        <i class="fa-solid fa-pen-to-square actions__icon"></i>
                    </a>
                    <form action="{{ route('category.destroy', $category->idCategory) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="actions__btn" onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')">
                            <i class="fa-solid fa-trash actions__icon"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- form thêm mới danh mục -->
@include('admin.categoryViews.categoryAdd')
@include('admin.categoryViews.categoryEdit')

@endsection