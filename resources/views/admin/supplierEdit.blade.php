<div class="formUpdate" id="supplierEditForm">
    <div class="overlay" id="overlay">
        <form class="formContent" id="supplierEdit__form">
            <h2>Chỉnh sửa nhà cung cấp</h2>
            
            <div class="form-group">
                <label for="supplierName">Tên nhà cung cấp <span style="color:red">*</span></label>
                <input type="text" id="editname" name="supplierName" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="editphone" name="phone" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="email">Email liên hệ</label>
                <input type="email" id="editemail" name="email" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <textarea id="editaddress" name="address" class="form-control" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label for="note">Ghi chú</label>
                <textarea id="editnote" name="note" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select id="status" name="status" class="form-control">
                    <option value="1" selected>Đang hợp tác</option>
                    <option value="0">Tạm ngưng</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
