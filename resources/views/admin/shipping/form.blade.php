@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Lỗi:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="product-form">
    <div class="form-section">
        @if (isset($shipping) && $shipping)
            <form action="{{ route('shipping.update', $shipping->id) }}" method="POST">
                @method('PUT')
        @else
                <form action="{{ route('shipping.store') }}" method="POST">
            @endif
                @csrf

                @if (!isset($shipping) || !$shipping)
                    <div class="form-group">
                        <label>Tỉnh/Thành phố <span class="text-danger">*</span></label>
                        <select name="province_id" id="province" class="form-control" required>
                            <option value="">-- Chọn tỉnh/thành phố --</option>
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov['Id'] }}" data-name="{{ $prov['Name'] }}">
                                    {{ $prov['Name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="province_name" id="province_name">

                    <div class="form-group">
                        <label>Quận/Huyện (Tùy chọn)</label>
                        <select name="district_id" id="district" class="form-control">
                            <option value="">-- Toàn tỉnh --</option>
                        </select>
                    </div>
                    <input type="hidden" name="district_name" id="district_name">

                    <div class="form-group">
                        <label>Phường/Xã (Tùy chọn)</label>
                        <select name="ward_id" id="ward" class="form-control">
                            <option value="">-- Toàn huyện --</option>
                        </select>
                    </div>
                    <input type="hidden" name="ward_name" id="ward_name">
                @else
                    <div class="form-group">
                        <label>Khu vực</label>
                        <p class="form-control-plaintext">
                            <strong>{{ $shipping->province_name }}</strong>
                            @if ($shipping->district_name)
                                > {{ $shipping->district_name }}
                            @endif
                            @if ($shipping->ward_name)
                                > {{ $shipping->ward_name }}
                            @endif
                        </p>
                    </div>
                @endif

                <div class="form-group">
                    <label>Phí giao hàng (đ) <span class="text-danger">*</span></label>
                    <input type="number" name="shipping_cost" class="form-control"
                        value="{{ old('shipping_cost', $shipping->shipping_cost ?? 0) }}" min="0" required>
                    <small class="text-muted">Nhập 0 để miễn phí giao hàng cho khu vực này</small>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $shipping->is_active ?? true) ? 'checked' : '' }}>
                        Đang hoạt động
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="product-form__button product-form__button--submit">
                        {{ isset($shipping) && $shipping ? 'Cập nhật' : 'Thêm khu vực' }}
                    </button>
                    <a href="{{ route('shipping.index') }}" class="product-form__button product-form__button--cancel">
                        Hủy
                    </a>
                </div>
            </form>
    </div>
</div>

<style>
    .alert {
        padding: 12px 16px;
        margin-bottom: 20px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
    }

    .product-form {
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto;
        padding-left: clamp(16px, 5%, 32px);
        padding-right: clamp(16px, 5%, 32px);
    }

    @media (max-width: 768px) {
        .product-form {
            grid-template-columns: 1fr;
        }
    }

    .form-section {
        background: white;
        padding: 24px;
        border-radius: 4px;
        border: 1px solid #ddd;
        flex: 1;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .text-danger {
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .text-muted {
        display: block;
        margin-top: 6px;
        color: #6c757d;
        font-size: 12px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #eee;
    }

    .product-form__button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
    }

    .product-form__button--submit {
        background-color: #28a745;
        color: white;
    }

    .product-form__button--submit:hover {
        background-color: #218838;
    }

    .product-form__button--cancel {
        background-color: #6c757d;
        color: white;
    }

    .product-form__button--cancel:hover {
        background-color: #545b62;
    }
</style>

<script>
    let provincesData = @json($provinces);
    let allDistricts = @json($districts ?? []);
    let allWards = @json($wards ?? []);

    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    if (provinceSelect) {
        provinceSelect.addEventListener('change', function () {
            districtSelect.innerHTML = '<option value="">-- Toàn tỉnh --</option>';
            wardSelect.innerHTML = '<option value="">-- Toàn huyện --</option>';

            const province = provincesData.find(p => String(p.Id) === String(this.value));
            if (province) {
                document.getElementById('province_name').value = province.Name;
                (province.Districts || []).forEach(d => {
                    districtSelect.innerHTML += `<option value="${d.Id}" data-name="${d.Name}">${d.Name}</option>`;
                });
            }
        });
    }

    if (districtSelect) {
        districtSelect.addEventListener('change', function () {
            wardSelect.innerHTML = '<option value="">-- Toàn huyện --</option>';

            const provinceId = provinceSelect.value;
            const province = provincesData.find(p => String(p.Id) === String(provinceId));
            if (province) {
                const district = province.Districts.find(d => String(d.Id) === String(this.value));
                if (district) {
                    document.getElementById('district_name').value = district.Name;
                    (district.Wards || []).forEach(w => {
                        wardSelect.innerHTML += `<option value="${w.Id}" data-name="${w.Name}">${w.Name}</option>`;
                    });
                }
            }
        });
    }

    if (wardSelect) {
        wardSelect.addEventListener('change', function () {
            const selected = wardSelect.options[wardSelect.selectedIndex];
            document.getElementById('ward_name').value = selected.dataset.name || '';
        });
    }
</script>