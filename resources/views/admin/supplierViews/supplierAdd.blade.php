<div class="formInput" id="supplierAddForm">
    <div class="overlay" id="overlay">
        <form class="formContent" id="supplierAdd__form" action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <h2>Thêm mới nhà cung cấp</h2>
            
            <div class="form-group">
                <label for="supplierName">Tên nhà cung cấp <span style="color:red">*</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên nhà cung cấp" value="{{ old('name') }}" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email liên hệ</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email liên hệ" value="{{ old('email') }}">
            </div>
            
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="{{ old('phone') }}" required>
            </div>
            
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <textarea id="address" name="address" class="form-control" rows="2" placeholder="Nhập địa chỉ..." >{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
                <label for="note">Ghi chú</label>
                <textarea id="note" name="note" class="form-control" rows="3" placeholder="Nhập ghi chú...">{{ old('address') }}</textarea>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>
