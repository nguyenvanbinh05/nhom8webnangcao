@extends('customer.layouts.myapp')
@section('title', 'Thanh toán')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
    <section class="checkout-section">
        <div class="checkout-grid">

            {{-- LEFT: FORM --}}
            <form class="checkout-form" id="checkout-form" method="POST" action="{{ route('checkout.place') }}"
                autocomplete="on">
                @csrf
                <h2>Thông tin giao hàng</h2>

                @if ($errors->has('address'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('address') }}
                    </div>
                @endif

                <div class="grid-2">
                    <div class="field">
                        <label for="name">Họ và tên</label>
                        <input id="name" name="name" type="text" placeholder="Họ và tên"
                            value="{{ old('name', auth()->user()->name ?? '') }}" required>
                        @error('name') <small class="text-error">{{ $message }}</small> @enderror
                    </div>
                    <div class="field">
                        <label for="phone">Số điện thoại</label>
                        <input id="phone" name="phone" type="tel" placeholder="Số điện thoại" value="{{ old('phone') }}"
                            required>
                        @error('phone') <small class="text-error">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" placeholder="Email"
                        value="{{ old('email', auth()->user()->email ?? '') }}">
                    @error('email') <small class="text-error">{{ $message }}</small> @enderror
                </div>

                <div class="address-select">
                    <select class="form-select form-select-sm mb-3" id="city" aria-label=".form-select-sm" required>
                        <option value="" selected>Chọn tỉnh thành</option>
                    </select>

                    <select class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm" required
                        disabled>
                        <option value="" selected>Chọn quận huyện</option>
                    </select>

                    <select class="form-select form-select-sm" id="ward" aria-label=".form-select-sm" required disabled>
                        <option value="" selected>Chọn phường xã</option>
                    </select>

                    <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id') }}">
                    <input type="hidden" name="city_name" id="city_name" value="{{ old('city_name') }}">
                    <input type="hidden" name="district_id" id="district_id" value="{{ old('district_id') }}">
                    <input type="hidden" name="district_name" id="district_name" value="{{ old('district_name') }}">
                    <input type="hidden" name="ward_id" id="ward_id" value="{{ old('ward_id') }}">
                    <input type="hidden" name="ward_name" id="ward_name" value="{{ old('ward_name') }}">
                </div>

                <div class="field">
                    <label for="address">Địa chỉ chi tiết</label>
                    <input id="address" name="address_detail" type="text" placeholder="Số nhà, đường, phường/xã…"
                        value="{{ old('address_detail') }}" required>
                    @error('address_detail') <small class="text-error">{{ $message }}</small> @enderror
                </div>

                <div class="field">
                    <label for="note">Ghi chú</label>
                    <textarea id="note" name="note" rows="3" placeholder="Ghi chú">{{ old('note') }}</textarea>
                </div>

                <h3>Hình thức thanh toán</h3>
                <div class="payment-method">
                    <label class="pay-option">
                        <input type="radio" name="payment" value="COD" checked>
                        <span class="icon">💵</span>
                        <span>Thanh toán khi nhận hàng (COD)</span>
                    </label>
                </div>

                <input type="hidden" name="full_address" id="full_address" value="{{ old('full_address') }}">
            </form>

            <aside class="checkout-summary">
                <ul class="cart-list">
                    @foreach ($items as $it)
                        @php
                            $p = $it->product;
                            $name = $p?->NameProduct ?? ('Sản phẩm #' . $it->product_id);
                            $img = $p && $p->MainImage ? asset('storage/' . $p->MainImage) : asset('images/products/placeholder.svg');
                            $line = (int) $it->price * (int) $it->quantity;
                            $lineTx = number_format($line, 0, ',', '.') . 'đ';
                        @endphp
                        <li class="cart-item">
                            <img src="{{ $img }}" alt="{{ $name }}">
                            <div class="info">
                                <a href="{{ route('product.show', $p?->idProduct ?? $it->product_id) }}"
                                    class="name">{{ $name }}</a>
                                <div class="meta">
                                    @if ($it->size)
                                        Size {{ $it->size }} *
                                    @endif
                                    x{{ $it->quantity }}
                                </div>
                            </div>
                            <div class="price">{{ $lineTx }}</div>
                        </li>
                    @endforeach
                </ul>

                <div class="totals">
                    <div class="row"><span>Tạm tính:</span><span
                            id="subtotal-display">{{ number_format($subtotal, 0, ',', '.') }}đ</span></div>
                    <div class="row">
                        <span>Phí ship:</span>
                        <span id="shipping-display">
                            @if ($shipping === 0)
                                <span style="color: #999; font-style: italic;">-- Chọn địa chỉ để xem phí --</span>
                            @else
                                {{ number_format($shipping, 0, ',', '.') }}đ
                            @endif
                        </span>
                    </div>
                    <div class="shipping-info">
                        <i class="fas fa-info-circle"></i>
                        <span>Miễn phí giao hàng cho đơn hàng trên 99.000đ</span>
                    </div>
                    <div class="grand">
                        <span>Tổng cộng</span>
                        <span class="grand-price" id="total-display">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                </div>
                <div class="actions">
                    <a class="btn-outline" href="{{ route('cart.index') }}">&lt; Giỏ hàng</a>
                    <button id="place-order" class="btn-primary" type="button">Thanh toán</button>
                </div>
            </aside>

        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        (function () {
            const citis = document.getElementById("city");
            const districts = document.getElementById("district");
            const wards = document.getElementById("ward");

            const cityId = document.getElementById('city_id');
            const cityName = document.getElementById('city_name');
            const districtId = document.getElementById('district_id');
            const districtName = document.getElementById('district_name');
            const wardId = document.getElementById('ward_id');
            const wardName = document.getElementById('ward_name');

            const addressDetail = document.getElementById('address');
            const fullAddress = document.getElementById('full_address');
            const form = document.getElementById('checkout-form');

            const subtotal = {{ $subtotal }};

            // Cập nhật phí ship khi thay đổi địa chỉ
            function updateShippingCost() {
                if (!cityId.value || !districtId.value || !wardId.value) {
                    console.log('Chưa chọn đủ địa chỉ');
                    return;
                }

                console.log('Đang tính phí ship...', {
                    subtotal: subtotal,
                    province_id: cityId.value,
                    district_id: districtId.value,
                    ward_id: wardId.value,
                });

                axios.post('{{ route("checkout.calculate-shipping") }}', {
                    subtotal: subtotal,
                    province_id: cityId.value,
                    district_id: districtId.value,
                    ward_id: wardId.value,
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                }).then(res => {
                    console.log('Kết quả:', res.data);
                    const data = res.data;

                    if (!data.supported) {
                        // Khu vực không hỗ trợ
                        document.getElementById('shipping-display').innerHTML =
                            '<span style="color: #dc3545; font-weight: bold;">❌ ' + data.message + '</span>';
                        document.getElementById('total-display').textContent =
                            number_format(subtotal, 0, ',', '.') + 'đ';
                    } else {
                        // Cập nhật phí ship
                        if (data.shipping_cost === 0) {
                            document.getElementById('shipping-display').innerHTML =
                                '<span style="color: #22c55e; font-weight: bold;">✓ Miễn phí</span>';
                        } else {
                            document.getElementById('shipping-display').textContent =
                                number_format(data.shipping_cost, 0, ',', '.') + 'đ';
                        }
                        document.getElementById('total-display').textContent =
                            number_format(data.total, 0, ',', '.') + 'đ';
                    }
                }).catch(err => {
                    console.error('Lỗi tính phí ship:', err);
                });
            }

            // Helper format number
            function number_format(n, decimals, dec_point, thousands_sep) {
                var c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals,
                    d = dec_point == undefined ? "," : dec_point,
                    t = thousands_sep == undefined ? "." : thousands_sep,
                    s = n < 0 ? "-" : "",
                    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                    j = (j = i.length) > 3 ? j % 3 : 0;
                return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
            }

            document.getElementById('place-order').addEventListener('click', function () {
                if (!addressDetail.value.trim() || !cityName.value || !districtName.value || !wardName.value) {
                    alert('Vui lòng nhập địa chỉ & chọn đầy đủ Tỉnh/Quận/Xã.');
                    return;
                }
                const parts = [
                    addressDetail.value.trim(),
                    wardName.value, districtName.value, cityName.value
                ].filter(Boolean);
                fullAddress.value = parts.join(', ');

                form.requestSubmit();
            });

            axios({
                url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
                method: "GET",
                responseType: "json",
            }).then(function (res) {
                const data = res.data || [];

                for (const x of data) {
                    citis.options[citis.options.length] = new Option(x.Name, x.Id);
                }

                citis.onchange = function () {
                    districts.length = 1; wards.length = 1;
                    districts.disabled = true; wards.disabled = true;

                    cityId.value = cityName.value = '';
                    districtId.value = districtName.value = wardId.value = wardName.value = '';

                    if (!this.value) return;
                    const found = data.find(n => String(n.Id) === String(this.value));
                    if (!found) return;

                    cityId.value = found.Id;
                    cityName.value = found.Name;

                    for (const k of found.Districts) {
                        districts.options[districts.options.length] = new Option(k.Name, k.Id);
                    }
                    districts.disabled = false;
                };

                districts.onchange = function () {
                    wards.length = 1; wards.disabled = true;
                    districtId.value = districtName.value = wardId.value = wardName.value = '';

                    const foundCity = data.find(n => String(n.Id) === String(citis.value));
                    if (!foundCity || !this.value) return;

                    const foundDistrict = foundCity.Districts.find(n => String(n.Id) === String(this.value));
                    if (!foundDistrict) return;

                    districtId.value = foundDistrict.Id;
                    districtName.value = foundDistrict.Name;

                    for (const w of foundDistrict.Wards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Id);
                    }
                    wards.disabled = false;

                    updateShippingCost();
                };

                wards.onchange = function () {
                    wardId.value = this.value || '';
                    wardName.value = this.options[this.selectedIndex]?.text || '';

                    updateShippingCost();
                };
            });
        })();
    </script>

    <style>
        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .shipping-info {
            margin-top: 12px;
            padding: 10px 12px;
            background-color: #e7f3ff;
            color: #0056b3;
            border-left: 3px solid #0056b3;
            border-radius: 3px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .shipping-info i {
            font-size: 14px;
        }
    </style>
@endsection