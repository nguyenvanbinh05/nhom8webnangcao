<div class="formUpdate">
    <div class="overlay" id="overlay">
        <form class="formContent" id="categoryupdateForm" method="POST">
             @csrf
             @method('PUT')
            <h2>Cập nhật thông tin</h2>

            <div class="form-group">
                <label for="name">Tên danh mục <span style="color:red">*</span></label>
                <input type="text" id="editNameCategory" name="nameCategory" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả ngắn</label>
                <textarea id="editdescription" name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select id="editstatus" name="status" class="form-control">
                    <option value="Available">Sẵn sàng</option>
                    <option value="Stopped">Ngừng sử dụng</option>
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
    const routeUpdateTemplate = "{{ route('category.update', ':id') }}";
</script>