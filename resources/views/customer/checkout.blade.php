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
                            $line = (int) $it->price * (int) $it->quantity;               // GIÁ * SL
                            $lineTx = number_format($line, 0, ',', '.') . 'đ';
                        @endphp
                        <li class="cart-item">
                            <img src="{{ $img }}" alt="{{ $name }}">
                            <div class="info">
                                <a href="{{ route('product.show', $p?->idProduct ?? $it->product_id) }}"
                                    class="name">{{ $name }}</a>
                                <div class="meta">Size {{ $it->size ?: '—' }} • x{{ $it->quantity }}</div>
                            </div>
                            <div class="price">{{ $lineTx }}</div>
                        </li>
                    @endforeach
                </ul>

                <div class="totals">
                    <div class="row"><span>Tạm tính:</span><span>{{ number_format($subtotal, 0, ',', '.') }}đ</span></div>
                    <div class="row"><span>Phí ship:</span><span>Miễn phí</span></div>
                    <div class="grand">
                        <span>Tổng cộng</span>
                        <span class="grand-price">{{ number_format($total, 0, ',', '.') }}đ</span>
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

            document.getElementById('place-order').addEventListener('click', function () {
                // Ghép địa chỉ trước khi submit
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
                };

                wards.onchange = function () {
                    wardId.value = this.value || '';
                    wardName.value = this.options[this.selectedIndex]?.text || '';
                };
            });
        })();
    </script>
@endsection