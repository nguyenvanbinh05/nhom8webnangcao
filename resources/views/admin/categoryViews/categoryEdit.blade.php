<div class="formUpdate">
    <div class="overlay" id="overlay">
        <form class="formContent" id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <h2>Cập nhật thông tin</h2>

            <div class="form-group">
                <label for="editNameCategory">Tên danh mục <span style="color:red">*</span></label>
                <input type="text" id="editNameCategory" name="nameCategory"
                    class="form-control @error('nameCategory') is-invalid @enderror"
                    placeholder="Nhập tên danh mục" value="{{ old('nameCategory') }}">
                @error('nameCategory')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Mô tả ngắn</label>
                <textarea id="editdescription" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select id="editstatus" name="status" class="form-control">
                    <option value="Available" {{ old('status', $category->Status ?? '') == 'Available' ? 'selected' : '' }}>Sẵn sàng</option>
                    <option value="Stopped" {{ old('status', $category->Status ?? '') == 'Stopped' ? 'selected' : '' }}>Ngừng sử dụng</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">cập nhật</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.buttonEditForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const route = this.dataset.route;
            const id = this.dataset.id;
            const name = this.dataset.name;
            const desc = this.dataset.desc;
            const status = this.dataset.status;

            const form = document.getElementById('editCategoryForm');
            form.action = route;

            // Điền dữ liệu vào form
            document.getElementById('editNameCategory').value = name;
            document.getElementById('editdescription').value = desc;
            document.getElementById('editstatus').value = status;

            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            form.querySelector('.form-control').classList.remove('is-invalid');
            document.querySelector('.formUpdate').classList.add("active");
        });
    });

    document.querySelectorAll('.btnCloseForm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Đóng form form
            document.querySelector('.formUpdate').classList.remove("active");
        });
    });
</script>

@if ($errors->any() && session('form') == 'edit')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.formUpdate').classList.add("active");
        const form = document.getElementById('editCategoryForm');
        form.action = "{{ session('route') }}";
    });
</script>
@endif