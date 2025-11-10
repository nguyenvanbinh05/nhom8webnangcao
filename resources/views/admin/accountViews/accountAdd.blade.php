<div class="formInput">
    <div class="overlay" id="overlay">
        <form action="{{ route('accounts.store') }}" method="POST" class="formContent formAddAccount">
            @csrf
            <h2 class="form-title">Tạo tài khoản mới</h2>

            <div class="form-group">
                <label class="form-label">Tên người dùng</label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                @error('phone')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input @error('password') is-invalid @enderror" required>
                @error('password')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Vai trò</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Chọn vai trò --</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Quản trị viên</option>
                    <option value="staff" {{ old('role')=='staff' ? 'selected' : '' }}>Nhân viên</option>
                    <option value="customer" {{ old('role')=='customer' ? 'selected' : '' }}>Khách hàng</option>
                </select>
                @error('role')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="display: none;">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                </select>
                @error('status')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Mở form khi nhấn nút "Thêm mới"
    document.querySelectorAll('.buttonAddForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.formAddAccount').reset();
            document.querySelector('.formAddAccount').querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            document.querySelector('.formInput').classList.add("active");
        });
    });

    // Đóng form khi nhấn nút Hủy
    document.querySelectorAll('.formInput .btnCloseForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.formInput').classList.remove("active");
        });
    });
</script>
@if ($errors->any() && session('form') == 'create')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.formInput').classList.add("active");
    });
</script>
@endif