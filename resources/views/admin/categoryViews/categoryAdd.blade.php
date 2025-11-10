<div class="formInput" id="categoryAddForm">
    <div class="overlay" id="overlay">
        <form class="formContent" id="categoryAdd__form" method="POST">
            @csrf
            <h2>Thêm mới danh mục</h2>

            <div class="form-group">
                <label for="name">Tên danh mục <span style="color:red">*</span></label>
                <input type="text" id="name" name="nameCategory"
                    class="form-control @error('nameCategory') is-invalid @enderror"
                    placeholder="Nhập tên danh mục">

                @error('nameCategory')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Mô tả ngắn</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Nhập mô tả ngắn..."></textarea>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select id="status" name="status" class="form-control">
                    <option value="Available" selected>Sẵn sàng</option>
                    <option value="Stopped">Ngừng sử dụng</option>
                </select>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.buttonAddForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const route = this.dataset.route;

            const form = document.getElementById('categoryAdd__form');
            form.action = route;

            // Reset form trước khi hiển thị
            form.reset();

            // Xóa các lỗi cũ (nếu có)
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            form.querySelectorAll('.form-control').forEach(function(input) {
                input.classList.remove('is-invalid');
            });
            document.querySelector('.formInput').classList.add("active");
        });
    });

    document.querySelectorAll('.btnCloseForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Đóng form form
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