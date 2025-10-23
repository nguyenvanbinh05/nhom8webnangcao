<!-- resources/views/customer/account/orders.blade.php -->
@extends('customer.account.layout')

@section('account')
    <h2>ĐƠN HÀNG CỦA BẠN</h2>

    @if($orders->isEmpty())
        <p class="muted">Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Đơn hàng</th>
                    <th>Ngày</th>
                    <th>Địa chỉ</th>
                    <th>Giá trị</th>
                    <th>TT thanh toán</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $o)
                    @php
                        $code = $o->code ? ('#WEB-' . $o->code) : ('#WEB-' . $o->idOrder);
                        $statusMap = [
                            'Pending' => ['Chờ duyệt', 'warn'],
                            'Processing' => ['Đang giao', 'shipping'],
                            'Completed' => ['Hoàn thành', 'success'],
                            'Cancelled' => ['Đã bị hủy', 'cancelled'],
                            'Canceled' => ['Đã bị hủy', 'cancelled'],
                        ];
                        [$label, $cls] = $statusMap[$o->status] ?? [$o->status, ''];

                        $payLabel = $o->payment_method === 'COD'
                            ? 'Thanh toán khi nhận hàng (COD)'
                            : $o->payment_method;
                    @endphp

                    <tr>
                        <td>
                            <a href="{{ route('account.orders.show', $o) }}">{{ $code }}</a>
                        </td>
                        <td>{{ optional($o->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $o->address }}</td>
                        <td style="color:#e74c3c">{{ number_format((int) $o->total, 0, ',', '.') }}đ</td>
                        <td>{{ $payLabel }}</td>
                        <td><span class="badge {{ $cls }}">{{ $label }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:12px">{{ $orders->links() }}</div>
    @endif
@endsection