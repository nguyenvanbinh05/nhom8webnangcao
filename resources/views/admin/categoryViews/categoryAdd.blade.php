<div class="formInput" id="categoryAddForm">
    <div class="overlay" id="overlay">
        <form class="formContent" id="categoryAdd__form" action="{{ route('category.store') }}" method="POST">
            @csrf
            <h2>Thêm mới danh mục</h2>

            <div class="form-group">
                <label for="name">Tên danh mục <span style="color:red">*</span></label>
                <input type="text" id="name" name="nameCategory" class="form-control" placeholder="Nhập tên danh mục" required>
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
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>