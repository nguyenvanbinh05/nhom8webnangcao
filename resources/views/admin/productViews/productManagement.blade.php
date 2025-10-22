@extends('layouts.layout_management')

@section('titlepage', 'coffee')


@section('content')
<div class="content__body">
    <div class="content__header">
        <!-- Search -->
        <form action="{{ route('adminProduct.index') }}" method="GET">
            <div class="search">
                <input type="text"
                    class="search__input"
                    name="search"
                    placeholder="Tìm kiếm theo id, tên sản phẩm..."
                    value="{{ $search ?? '' }}">
                <button type="submit" class="search__btn">
                    <i class="fa-solid fa-magnifying-glass search__icon"></i>
                </button>
            </div>
        </form>
        <!-- Action buttons -->
        <a href="{{ route('adminProduct.create') }}" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>

    </div>

    <!-- Table -->
    <table class="table">
        <thead class="table__head">
            <tr class="table__row">
                <th class="table__cell">Stt</th>
                <th class="table__cell">Sản phẩm</th>
                <th class="table__cell">Loại</th>
                <th class="table__cell">Giá</th>
                <th class="table__cell">Ngày thêm</th>
                <th class="table__cell">Trạng thái</th>
                <th class="table__cell">Thao tác</th>
            </tr>
        </thead>
        <tbody class="table__body">
            @forelse($products as $index => $product)
            <tr class="table__row">
                <td class="table__cell">{{ $index + 1 }}</td>
                <td class="table__cell productInfo">
                    <img src="{{ asset('storage/' . $product->MainImage) }}" alt="{{ $product->NameProduct }}" class="order__img">
                    <div class="productInfo__details">
                        <span class="productInfo__name">{{ $product->NameProduct }}</span>
                    </div>
                </td>
                <td class="table__cell">{{ $product->category->NameCategory }}</td>
                <td class="table__cell">
                    @if($product->Price != NULL)
                    {{ number_format($product->Price, 0, ',', '.') }} đ
                    @elseif($product->Price == NULL && $product->sizes->count() > 0)
                    {{ number_format($product->sizes->min('Price'), 0, ',', '.') }} đ
                    -
                    {{ number_format($product->sizes->max('Price'), 0, ',', '.') }} đ
                    @else
                    Chưa có giá
                    @endif
                </td>
                <td class="table__cell">{{ $product->created_at->format('d/m/Y') }}</td>
                <td class="table__cell">
                    @if($product->Status == 'Available')
                    <span class="status status--shipping">Sẵn sàng</span>
                    @else
                    <span class="status status--stopped">Tạm ngừng</span>
                    @endif
                </td>
                <td class="table__cell actions-column">
                    <div class="action-item">
                        <a href="{{ route('adminProduct.show', $product->idProduct) }}"
                            class="apd-actions-btn apd-btn-show-detail" title="Xem chi tiết">
                            <i class="fa-regular fa-eye apd-actions-icon"></i>
                        </a>
                        <a href="{{ route('adminProduct.edit', $product->idProduct) }}" class="actions__btn"><i
                                class="fa-solid fa-pen-to-square actions__icon"></i></a>
                        <form action="{{ route('adminProduct.destroy', $product->idProduct) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');">
                            @csrf
                            @method('DELETE')
                            <button class="actions__btn"><i
                                    class="fa-solid fa-trash actions__icon"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Không có sản phẩm nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection