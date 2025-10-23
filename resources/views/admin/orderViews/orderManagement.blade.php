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
        <!-- <a href="{{ route('ingredients.create') }}" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a> -->
    </div>
    <!-- table -->
    <table class="table">
        <thead class="table__head">
            <tr class="table__row">
                <th class="table__cell">STT</th>
                <th class="table__cell">Mã đơn hàng</th>
                <th class="table__cell">khách hàng</th>
                <th class="table__cell">ngày đặt</th>
                <th class="table__cell">Tổng tiền</th>
                <th class="table__cell">Trạng thái</th>
                <th class="table__cell">Thanh toán</th>
                <th class="table__cell">Thao tác</th>
            </tr>
        </thead>
        <tbody class="table__body">
            @forelse ($orders as $index => $order)
            <tr class="table__row">
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->code }}</td>
                <td>{{ $order->full_name }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ number_format($order->total, 0, ',', '.') }} đ</td>
                <td>
                    <span class="status status--{{ strtolower($order->status) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->payment_method }}</td>
                <td class="table__cell actions">
                    <a href="{{ route('orderManagement.show', $order->idOrder) }}" class="actions__btn">
                        <i class="fa-regular fa-eye actions__icon"></i>
                    </a>
                    @if($order->status != "Completed" && $order->status != "Pending" && $order->status != "Cancelled")
                    <form action="{{ route('orderManagement.confirm', $order->idOrder) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn chuyển trạng thái đơn hàng sang thành công không?')">
                        @csrf
                        <button type="submit" class="btn btn-success">Câp nhật trạng thái</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Không có sản phẩm nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection