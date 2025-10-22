<div class="formUpdate">
    <div class="overlay" id="overlay">
        <form method="POST" class="formContent" id="editUserForm">
            @csrf
            @method('PUT')
            <h2 class="form-title">Cập nhật tài khoản</h2>

            <div class="form-group">
                <label class="form-label">Tên người dùng</label>
                <input type="text" name="name" id="editName" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="editEmail" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" id="editPhone" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input">
                <small style="color: gray;">Lưu ý: Để trống nếu không muốn thay đổi mật khẩu</small>
            </div>

            <div class="form-group">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Vai trò</label>
                <select name="role" id="editRole" class="form-select" required>
                    <option value="">-- Chọn vai trò --</option>
                    <option value="admin">Quản trị viên</option>
                    <option value="staff">Nhân viên</option>
                    <option value="customer">Khách hàng</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Trạng thái</label>
                <select name="status" id="editStatus" class="form-select" required>
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Ngừng hoạt động</option>
                </select>
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
            document.getElementById('editStatus').value = status;

            // document.getElementById('overlay').style.display = 'block';

            // Hiển thị form
            document.querySelector('.formUpdate').classList.add("active");
        });
    });
</script>