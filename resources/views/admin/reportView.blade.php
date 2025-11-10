@extends('layouts.layout_management')

@section('content')
<div class="content__body">
    <h1 class="title">Báo cáo & Thống kê</h1>

    <div class="report-section">
        <h2> Doanh thu theo ngày</h2>
        <form id="filterForm" style="margin-bottom:20px;">
            <label for="startDate">Từ ngày:</label>
            <input type="date" id="startDate" name="startDate" value="{{ $start }}">

            <label for="endDate">Đến ngày:</label>
            <input type="date" id="endDate" name="endDate" value="{{ $end }}">

            <button type="submit">Lọc</button>
        </form>
        <canvas id="revenueChart"></canvas>
    </div>

    <div class="report-row" style="display: flex; gap: 100px; margin-top: 50px;">
        <div class="report-section" style="flex: 2;">
            <h2>5 đơn hàng mới nhất</h2>
            <table class="table table-bordered" style="width: 100%; text-align: center;">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestOrders as $order)
                    <tr>
                        <td>#{{ $order->idOrder }}</td>
                        <td>{{ $order->user->name ?? 'Không rõ' }}</td>
                        <td>{{ number_format($order->total, 0, ',', '.') }} ₫</td>
                        <td>
                            <span class="status status--{{ $order->status_color }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="report-section" style="flex: 1;">
            <h2>Top 5 sản phẩm bán chạy</h2>
            <canvas id="topProductsChart" height="250"></canvas>
        </div>
    </div>
</div>

{{-- Dữ liệu cho JS --}}
<div
    id="report-data-container"
    data-labels='@json($dates)'
    data-revenue='@json($totals)'
    data-products='@json($productNames)'
    data-sales='@json($productSales)'
    style="display: none;">
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/report.js') }}"></script>
@endsection