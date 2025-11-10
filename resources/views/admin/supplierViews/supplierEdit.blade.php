<div class="formUpdate" id="supplierEditForm">
    <div class="overlay" id="overlay">
        <div class="formContent">
            <h2>Chỉnh sửa nhà cung cấp</h2>
            <form id="supplierEdit__form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">

                <div class="form-group">
                    <label for="editname">Tên nhà cung cấp <span style="color:red">*</span></label>
                    <input type="text" id="editname" name="supplierName" class="form-control" value="{{ old('supplierName') }}" required>
                </div>

                <div class="form-group">
                    <label for="editphone">Số điện thoại</label>
                    <input type="tel" id="editphone" name="phone" class="form-control" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="editemail">Email liên hệ</label>
                    <input type="email" id="editemail" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="editaddress">Địa chỉ</label>
                    <textarea id="editaddress" name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="editnote">Ghi chú</label>
                    <textarea id="editnote" name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="#" class="btn btn-secondary" id="cancelEdit">Hủy</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.buttonEditForm').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            document.getElementById('supplierEdit__form').querySelectorAll('.text-danger').forEach(el => el.remove());

            const modal = document.getElementById('supplierEditForm');
            modal.style.display = 'block';

            // Điền dữ liệu vào form
            const form = document.getElementById('supplierEdit__form');
            form.action = this.dataset.route;
            form.querySelector('input[name="id"]').value = this.dataset.id;
            form.querySelector('input[name="supplierName"]').value = this.dataset.name;
            form.querySelector('input[name="phone"]').value = this.dataset.phone;
            form.querySelector('input[name="email"]').value = this.dataset.email;
            form.querySelector('textarea[name="address"]').value = this.dataset.address;
            form.querySelector('textarea[name="note"]').value = this.dataset.note;
        });
    });

    // Hủy / đóng modal
    document.getElementById('cancelEdit').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('supplierEditForm').style.display = 'none';
    });

    // Đóng modal khi click ngoài overlay
    document.getElementById('overlay').addEventListener('click', function(e) {
        if (e.target === this) {
            this.parentElement.style.display = 'none';
        }
    });
</script>

@if ($errors->any() && session('form') == 'edit')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.formUpdate').classList.add("active");
        const form = document.getElementById('supplierEdit__form');
            form.action = "{{ session('route') }}";
    });
</script>
@endif