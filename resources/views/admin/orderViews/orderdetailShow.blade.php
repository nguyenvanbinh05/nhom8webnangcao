@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')
<div class="content_body">

    <div class="invoice-details">
        <div class="invoice-header">
            <h2>Chi Tiết Hóa Đơn</h2>
        </div>

        <div class="invoice-body">
            <div class="invoice-info">
                <div class="info-left">
                    <p><strong>Mã:</strong> {{ $order->code }}</p>
                    <p><strong>Ngày Lập:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                    <p><strong>Người Lập:</strong> {{ $order->created_by ?? 'Mua Online' }}</p>
                    <p><strong>Tổng Tiền:</strong> {{ number_format($order->total) }} VNĐ</p>
                    <p><strong>Hình Thức Thanh Toán:</strong> {{ $order->payment_method }}</p>
                </div>
                <div class="info-right">
                    <p><strong>Khách Hàng:</strong> {{ $order->full_name }}</p>
                    <p><strong>Email:</strong> {{ $order->email ?? '-' }}</p>
                    <p><strong>SĐT Khách Hàng:</strong> {{ $order->phone ?? '-' }}</p>
                    <p><strong>Địa Chỉ Khách Hàng:</strong> {{ $order->address ?? '-' }}</p>
                    <p><strong>Trạng Thái:</strong>
                        <span class="status-{{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
                <div>
                    <p><strong>Khách Hàng Ghi Chú:</strong> {{ $order->note ?? '-' }}</p>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th class="col-item">Mặt Hàng</th>
                        <th class="col-price">Size</th>
                        <th class="col-price">Đơn Giá</th>
                        <th class="col-quantity">Số Lượng</th>
                        <th class="col-total">Tổng Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="col-name">{{ $item->product->NameProduct }}</td>
                        <td class="col-size">
                            @if(is_null($item->product->price) || $item->product->price == 0)
                            {{ $item->size ?? '-' }}
                            @endif
                        </td>
                        <td class="col-price">{{ number_format($item->unit_price) }} VNĐ</td>
                        <td class="col-quantity">{{ $item->quantity }}</td>
                        <td class="col-total">{{ number_format($item->unit_price * $item->quantity) }} VNĐ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="invoice-footer">
            <a href="{{ route('orderManagement.index') }}" class="close-btn">Đóng</a>
            @if($order->status === 'Pending')
            <form action="{{ route('orderManagement.confirm', $order->idOrder) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Xác nhận đơn hàng</button>
            </form>
            @endif
        </div>
    </div>
</div>

@endsection