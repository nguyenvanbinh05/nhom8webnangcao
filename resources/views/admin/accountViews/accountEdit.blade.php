<div class="formUpdate">
    <div class="overlay" id="overlay">
        <form method="POST" class="formContent" id="editUserForm">
            @csrf
            @method('PUT')
            <h2 class="form-title">Cập nhật tài khoản</h2>

            <div class="form-group">
                <label class="form-label">Tên người dùng</label>
                <input type="text" name="name" id="editName" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="editEmail" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" id="editPhone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                @error('phone')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input @error('password') is-invalid @enderror">
                <small style="color: gray;">Lưu ý: Để trống nếu không muốn thay đổi mật khẩu</small>
                @error('password')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Vai trò</label>
                <select name="role" id="editRole" class="form-select @error('role') is-invalid @enderror">
                    <option value="">-- Chọn vai trò --</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Quản trị viên</option>
                    <option value="staff" {{ old('role')=='staff' ? 'selected' : '' }}>Nhân viên</option>
                    <option value="customer" {{ old('role')=='customer' ? 'selected' : '' }}>Khách hàng</option>
                </select>
                @error('role')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Trạng thái</label>
                <select name="status" id="editStatus" class="form-select @error('status') is-invalid @enderror">
                    <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                </select>
                @error('status')
                <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.querySelectorAll('.buttonEditForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const route = this.dataset.route;
            const userId = this.dataset.id;
            const name = this.dataset.name;
            const email = this.dataset.email;
            const phone = this.dataset.phone;
            const role = this.dataset.role;
            const status = this.dataset.status;

            const form = document.getElementById('editUserForm');
            form.action = route;

            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editRole').value = role;
            //document.getElementById('editStatus').value = status;
            const selectStatus = document.getElementById('editStatus');
            selectStatus.value = status; // chọn option tương ứng

            document.querySelectorAll('#editUserForm .form-input').forEach(function(input) {
                input.classList.remove('is-invalid');
            });
            document.getElementById('editUserForm').querySelectorAll('.invalid-feedback').forEach(el => el.remove());

            // Hiển thị form
            document.querySelector('.formUpdate').classList.add("active");
        });
    });

    // Đóng form khi nhấn nút Hủy
    document.querySelectorAll('.formUpdate .btnCloseForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.formUpdate').classList.remove("active");
        });
    });
</script>
@if ($errors->any() && session('form') == 'edit')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.formUpdate').classList.add("active");
        const form = document.getElementById('editUserForm');
            form.action = "{{ session('route') }}";
    });
</script>
@endif