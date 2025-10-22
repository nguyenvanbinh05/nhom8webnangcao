<div class="formInput">
    <div class="overlay" id="overlay">
        <form action="{{ route('accounts.store') }}" method="POST" class="formContent">
            @csrf
            <h2 class="form-title">Tạo tài khoản mới</h2>
            <div class="form-group">
                <label class="form-label">Tên người dùng</label>
                <input type="text" name="name" class="form-input" value="" required>
            </div>
    
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="" required>
            </div>
    
            <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-input" value="">
            </div>
    
            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input" required>
            </div>
    
            <div class="form-group">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>
    
            <div class="form-group">
                <label class="form-label">Vai trò</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Chọn vai trò --</option>
                    <option value="admin">Quản trị viên</option>
                    <option value="staff">Nhân viên</option>
                    <option value="customer">Khách hàng</option>
                </select>
            </div>
    
            <div class="form-group">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select" required>
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Ngừng hoạt động</option>
                </select>
            </div>
    
            <div class="form-actions">
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>