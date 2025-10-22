@extends('customer.layouts.myapp')
@section('title', 'Đơn hàng của tôi')

@section('content')
    <section class="fade-in">
        <div class="main-content">
            <h2>Đơn hàng của tôi</h2>
            @forelse($orders as $od)
                <div class="order-card">
                    <div><strong>{{ $od->code }}</strong> • {{ $od->status }}</div>
                    <div>{{ $od->created_at->format('d/m/Y H:i') }}</div>
                    <div>Tổng: {{ number_format($od->total, 0, ',', '.') }}đ ({{ $od->items_count }} sp)</div>
                    <a href="{{ route('orders.show', $od->idOrder) }}">Xem chi tiết</a>
                </div>
            @empty
                <p>Chưa có đơn hàng.</p>
            @endforelse

            {{ $orders->links() }}
        </div>
    </section>
@endsection