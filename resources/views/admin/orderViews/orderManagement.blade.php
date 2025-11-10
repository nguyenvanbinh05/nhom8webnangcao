@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')


<div class="content_body">
    <div class="content__header">
        <!-- Search -->
        <form action="{{ route('orderManagement.index') }}" method="GET">
            <div class="search">
                <input type="text"
                    class="search__input"
                    name="search"
                    placeholder="Tìm kiếm ..."
                    value="{{ $search ?? '' }}">
                <button type="submit" class="search__btn">
                    <i class="fa-solid fa-magnifying-glass search__icon"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="status-bar">
        <a href="{{ route('orderManagement.index') }}"
            class="status-item {{ request('status') ? '' : 'active' }}">
            Tất cả
        </a>
        <a href="{{ route('orderManagement.index', ['status' => 'Pending']) }}"
            class="status-item {{ request('status') == 'Pending' ? 'active' : '' }}">
            Chờ xác nhận
        </a>
        <a href="{{ route('orderManagement.index', ['status' => 'Processing']) }}"
            class="status-item {{ request('status') == 'Processing' ? 'active' : '' }}">
            Đang xử lý
        </a>
        <a href="{{ route('orderManagement.index', ['status' => 'Completed']) }}"
            class="status-item {{ request('status') == 'Completed' ? 'active' : '' }}">
            Thành công
        </a>
        <a href="{{ route('orderManagement.index', ['status' => 'Cancelled']) }}"
            class="status-item {{ request('status') == 'Cancelled' ? 'active' : '' }}">
            Đã hủy
        </a>
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
                    <span class="status status--{{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </td>
                <td>{{ $order->payment_method }}</td>
                <td class="table__cell actions">
                    <a href="{{ route('orderManagement.show', $order->idOrder) }}" class="actions__btn">
                        <!-- <i class="fa-regular fa-eye actions__icon"></i> -->
                        Chi tiết
                    </a>
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
<script>
    const items = document.querySelectorAll('.status-item');

    items.forEach(item => {
        item.addEventListener('click', () => {
            // Bỏ class active ở tất cả
            items.forEach(i => i.classList.remove('active'));
            // Thêm class active vào phần được chọn
            item.classList.add('active');

            // Lấy tên trạng thái (loại bỏ dấu cách thừa)
            const status = item.textContent.trim();

            // Chuyển hướng đến URL có ?status=<tên trạng thái>
            const url = new URL(window.location.href);
            url.searchParams.set('status', status);
            window.location.href = url.toString();
        });
    });
</script>

@endsection