@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')
<div class="content_body">

    <div class="invoice-details">
        <div class="invoice-header">
            <h2>Chi Tiết Hóa Đơn</h2>
            <a href="{{ route('orderManagement.index') }}">
                <i class="fa-solid fa-xmark icon__close"></i>
            </a>
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
                    <p><strong>Email:</strong> {{ $order->email ?? 'Không có' }}</p>
                    <p><strong>SĐT Khách Hàng:</strong> {{ $order->phone ?? 'Không có' }}</p>
                    <p><strong>Địa Chỉ Khách Hàng:</strong> {{ $order->address ?? 'Không có' }}</p>
                </div>
            </div>
            <div class="note-customer">
                <p><strong>Khách Hàng Ghi Chú:</strong> {{ $order->note ?? 'Không có' }}</p>
            </div>
            <div class="statusOrder">
                <p><strong>Trạng Thái:</strong>
                    <span class="status status--{{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </p>
                @if($order->status === 'Cancelled' && $order->cancel_reason)
                <p style="color: #e53935;">Lý do hủy: {{ $order->cancel_reason }}</p>
                @endif
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th class="table__count">STT</th>
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
                        <td>{{ $loop->iteration }}</td>
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
            @if($order->status === 'Pending')
            <button type="button" class="btn btn-danger">Hủy đơn hàng</button>
            <form action="{{ route('orderManagement.confirm', $order->idOrder) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Xác nhận đơn hàng</button>
            </form>
            @elseif($order->status != 'Completed' && $order->status != 'Cancelled')
            <div class="confirmOrder">
                <button type="button" class="btn btn-danger">Hủy đơn hàng</button>
            </div>
            <form action="{{ route('orderManagement.confirm', $order->idOrder) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn chuyển trạng thái đơn hàng sang thành công không?')">
                @csrf
                <button type="submit" class="btn btn-success">Câp nhật trạng thái</button>
            </form>
            @endif
        </div>
    </div>
</div>

<div class="reasonCancel">
    <div class="overlay" id="overlay">
        <form action="{{ route('orderManagement.cancel', $order->idOrder) }}" method="POST" style="display:inline-block;" class="formContent">
            @csrf
            <h2>Lý do hủy đơn</h2>

            <div class="form-group">
                <label for="reason">Nhập nội dung vào ô dưới:</label>
                <textarea id="reason" name="cancel_reason" class="form-control" rows="3" placeholder="Nhập lý do..." required></textarea>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // mở form
            document.querySelector('.reasonCancel').classList.add("active");
        });
    });
    document.querySelectorAll('.btnCloseForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Đóng form
            document.querySelector('.reasonCancel').classList.remove("active");
        });
    });
</script>

@endsection