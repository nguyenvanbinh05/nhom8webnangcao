@extends('customer.layouts.myapp')
@section('title', 'Chi tiết đơn ' . $order->code)

@section('content')
    <section class="fade-in">
        <div class="main-content">
            <h2>Đơn {{ $order->code }}</h2>
            <p>Trạng thái: <strong>{{ $order->status }}</strong></p>
            <p>Người nhận: {{ $order->full_name }} • {{ $order->phone }}</p>
            <p>Địa chỉ: {{ $order->address }}</p>
            <hr>
            @foreach ($order->items as $it)
                <div class="order-item">
                    <div>{{ $it->product_name }} (Size {{ $it->size ?: '—' }}) x{{ $it->quantity }}</div>
                    <div>{{ number_format($it->unit_price, 0, ',', '.') }}đ</div>
                    <div>= {{ number_format($it->line_total, 0, ',', '.') }}đ</div>
                </div>
            @endforeach
            <hr>
            <p>Tạm tính: {{ number_format($order->subtotal, 0, ',', '.') }}đ</p>
            <p>Phí ship: {{ number_format($order->shipping, 0, ',', '.') }}đ</p>
            <p>Giảm giá: {{ number_format($order->discount, 0, ',', '.') }}đ</p>
            <h3>Tổng: {{ number_format($order->total, 0, ',', '.') }}đ</h3>
        </div>
    </section>
@endsection