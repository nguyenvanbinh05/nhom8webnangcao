@extends('customer.account.layout')

@section('account')
    <section class="order-detail">
        @php
            // Map EN -> VI
            $statusMap = [
                'Pending' => 'Chờ duyệt',
                'Processing' => 'Đang giao',
                'Completed' => 'Đã hoàn thành',
                'Cancelled' => 'Đã bị hủy',
                'Canceled' => 'Đã bị hủy', // đề phòng khác chính tả
            ];

            $statusEn = $order->status ?? 'Pending';
            $statusVi = $statusMap[$statusEn] ?? $statusEn;


            $statusColor = match ($statusEn) {
                'Completed' => '#2e7d32',
                'Cancelled', 'Canceled' => '#e53935',
                'Processing' => '#fb8c00',
                default => '#1e88e5',
            };

            $fmt = fn($n) => number_format((int) $n, 0, ',', '.') . 'đ';
            $dateAt = optional($order->created_at)->format('d/ m/ Y');
            $canceled = in_array($statusEn, ['Cancelled', 'Canceled']);
        @endphp

        <h3 class="title">
            Chi tiết đơn hàng <span style="font-weight:600;">#WEB-{{ $order->code ?? $order->idOrder }}</span>
        </h3>

        <div class="status">
            <div>
                <span>Trạng thái đơn hàng:</span>
                <strong style="color:{{ $statusColor }}">{{ $statusVi }}</strong>
            </div>
            <div style="opacity:.8">Ngày tạo: {{ $dateAt }}</div>
        </div>

        @if($canceled)
            <div class="day-of-destroy">
                Ngày hủy: {{ optional($order->updated_at)->format('d/ m/ Y') }}
            </div>
        @endif

        <div class="infor">
            <div class="adress">
                <div id="title">ĐỊA CHỈ GIAO HÀNG</div>
                <div style="text-transform:uppercase;font-weight:700">{{ $order->full_name }}</div>
                <div style="margin-top:6px"><strong>Địa chỉ:</strong> {{ $order->address }}</div>
                <div><strong>Số điện thoại:</strong> {{ $order->phone }}</div>
            </div>

            {{-- Thanh toán --}}
            <div class="payment-method">
                <div id="title">THANH TOÁN</div>
                <div>{{ $order->payment_method === 'COD' ? 'Thanh toán khi giao hàng (COD)' : $order->payment_method }}
                </div>
            </div>

            {{-- Ghi chú --}}
            <div class="note">
                <div id="title">GHI CHÚ</div>
                <div>{{ $order->note ?: 'Không có ghi chú' }}</div>
            </div>
        </div>

        {{-- DANH SÁCH SẢN PHẨM --}}
        <div class="product-list">
            <div class="title" style="padding:14px 16px;font-weight:700;border-bottom:1px solid #eee;background:#fafafa">
                DANH SÁCH SẢN PHẨM</div>

            <table>
                <thead>
                    <tr class="table-title">
                        <th style="text-align:left;padding:10px 16px;width:48%">Sản phẩm</th>
                        <th style="text-align:right;padding:10px 16px;width:14%">Đơn giá</th>
                        <th style="text-align:center;padding:10px 16px;width:10%">Số lượng</th>
                        <th style="text-align:right;padding:10px 16px;width:14%">Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $it)
                        @php
                            $nameFromItem = $it->product_name ?? null;
                            $imgFromItem = $it->product_image ?? null;

                            $p = $it->relationLoaded('product') ? $it->product : null;
                            $name = $nameFromItem ?: ($p?->NameProduct ?? ('Sản phẩm #' . $it->product_id));
                            $imgRel = $p?->MainImage;

                            $imgPath = $imgFromItem ?: $imgRel;
                            $img = $imgPath ? asset('storage/' . $imgPath) : asset('images/products/placeholder.svg');
                            $qty = (int) ($it->quantity ?? 0);
                            $line = (int) ($it->line_total ?? ($unit * $qty));
                        @endphp

                        <tr class="info-product">
                            <td style="padding:12px 16px">
                                <div style="display:flex;gap:12px;align-items:center">
                                    <img src="{{ $img }}" alt="{{ $name }}"
                                        style="width:64px;height:64px;border-radius:8px;object-fit:cover">
                                    <div>
                                        <div style="font-weight:600;margin-bottom:4px">{{ $name }}</div>
                                        @if($it->size)
                                            <div style="opacity:.75">Size {{ $it->size }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td style="text-align:right;padding:12px 16px;">{{ $fmt($it->unit_price) }}</td>
                            <td style="text-align:center;padding:12px 16px">{{ $it->quantity }}</td>
                            <td style="text-align:right;padding:12px 16px;color: green;">{{ $fmt($it->line_total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TOTALS --}}
        <div class="totals">
            <div style="width:360px">
                <div style="display:flex;justify-content:space-between;margin:6px 0">
                    <span>Tạm tính:</span>
                    <strong id="totals">{{ $fmt($order->subtotal) }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;margin:6px 0">
                    <span>Phí ship:</span>
                    <strong>{{ $order->shipping ? $fmt($order->shipping) : 'Miễn phí' }}</strong>
                </div>
                @if((int) $order->discount > 0)
                    <div style="display:flex;justify-content:space-between;margin:6px 0">
                        <span>Giảm giá:</span>
                        <strong>-{{ $fmt($order->discount) }}</strong>
                    </div>
                @endif
                <div
                    style="display:flex;justify-content:space-between;margin-top:10px;border-top:1px dashed #bebebe;padding-top:12px">
                    <span style="font-weight:700">Tổng cộng</span>
                    <span id="totals">{{ $fmt($order->total) }}</span>
                </div>
            </div>
        </div>
        @if(session('alert'))
            <script>
                alert(@json(session('alert')));
            </script>
        @endif
    </section>
@endsection