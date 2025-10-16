<div class="formUpdate" id="supplierEditForm">
    <div class="overlay" id="overlay">
        <form class="formContent" id="supplierEdit__form" action="{{ route('supplier.update', $supplier->id) }}" method="POST">
            <h2>Chỉnh sửa nhà cung cấp</h2>

            <div class="form-group">
                <label for="supplierName">Tên nhà cung cấp <span style="color:red">*</span></label>
                <input type="text" id="editname" name="supplierName" class="form-control" value="{{ old('supplierName', $supplier->name) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="editphone" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
            </div>

            <div class="form-group">
                <label for="email">Email liên hệ</label>
                <input type="email" id="editemail" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <textarea id="editaddress" name="address" class="form-control" rows="2">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="form-group">
                <label for="note">Ghi chú</label>
                <textarea id="editnote" name="note" class="form-control" rows="3">{{ old('note', $supplier->note) }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Hủy</a>
                <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-secondary">Cập nhật</button>
                </form>
            </div>
        </form>
    </div>
</div>