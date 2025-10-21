@extends('layouts.layout_management')
@section('content')
<div class="container">
    <h1>Thêm sản phẩm mới</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="product-form__group">
            <div class="product-form__field">
                <label class="product-form__label" for="productName"><span style="color: red">* </span>Tên sản phẩm</label>
                <input class="product-form__input" type="text" id="productName" name="NameProduct"
                    placeholder="Nhập tên sản phẩm">
            </div>
        </div>

        <div class="product-form__group">
            <div class="product-form__field">
                <label class="product-form__label"><span style="color: red">* </span>Ảnh chính</label>
                <div class="product-form__image-box" id="mainImageBox">
                    <input class="product-form__file" type="file" id="mainImage" name="MainImage"
                        accept="image/*">
                    <div class="product-form__image-placeholder">
                        <i class="fa-solid fa-cloud-arrow-up icon-uploadFile"></i>
                        <span>+ Chọn ảnh</span>
                    </div>
                    <img id="mainImagePreview" class="product-form__image-preview"
                        alt="Xem trước ảnh chính" style="display: none;">
                </div>
            </div>

            <div class="product-form__field">
                <label class="product-form__label">Ảnh phụ</label>
                <div class="product-form__additional-images">
                    <input class="product-form__file" type="file" id="additionalImage"
                        name="additationImages[]" accept="image/*" multiple>
                    <div id="additionalImagesPreview" class="product-form__image-list">
                        <div class="product-form__additional-action">
                            <span>+</span>
                            <span>Thêm ảnh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-form__group">
            <div class="product-form__field">
                <label class="product-form__label" for="brand"><span style="color: red">* </span>Loại sản phẩm</label>
                <select class="product-form__input" id="brand" name="CategoryId">
                    @foreach(App\Models\Category::all() as $category)
                    <option value="{{ $category->idCategory }}">{{ $category->NameCategory }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <!-- Giá bán -->
        <div class="product-form__field">
            <label class="product-form__label" for="productType"><span style="color: red">*</span> Quản lý giá bán</label>
            <select class="product-form__input" id="productType" name="productType" required>
                <option value="">-- Chọn loại --</option>
                <option value="single">1 size / giá cố định</option>
                <option value="multiple">Nhiều size</option>
            </select>
        </div>

        <!-- Giá cố định cho 1 size -->
        <div class="product-form__field" id="singlePriceField" style="display:none;">
            <label class="product-form__label" for="price"><span style="color:red">*</span> Giá bán</label>
            <input class="product-form__input" type="number" id="price" name="Price" placeholder="Nhập giá bán">
        </div>

        <!-- Nhiều size -->
        <div class="product-form__group" id="multipleSizeField" style="display:none;">
            <label class="product-form__label">Chọn size và nhập giá</label>
            <div class="product-form__checkbox-group">
                <div class="size-item mb-2">
                    <input type="checkbox" name="sizes[0][Size]" value="S"> S
                    <input type="number" name="sizes[0][Price]" placeholder="Giá S" class="product-form__input">
                </div>
                <div class="size-item mb-2">
                    <input type="checkbox" name="sizes[1][Size]" value="M"> M
                    <input type="number" name="sizes[1][Price]" placeholder="Giá M" class="product-form__input">
                </div>
                <div class="size-item mb-2">
                    <input type="checkbox" name="sizes[2][Size]" value="L"> L
                    <input type="number" name="sizes[2][Price]" placeholder="Giá L" class="product-form__input">
                </div>
            </div>
        </div>

        <div class="product-form__field">
            <label class="product-form__label" for="status"><span style="color: red">* </span>Trạng thái</label>
            <select class="product-form__select" id="status" name="Status">
                <option value="Available" selected>Sẵn sàng</option>
                <option value="Stopped">Ngừng kinh doanh</option>
            </select>
        </div>

        <div class="product-form__field">
            <label class="product-form__label" for="detailedDescription"><span style="color: red">* </span>Mô tả chi tiết</label>
            <textarea class="product-form__textarea" id="detailedDescription" name="Description"
                placeholder="Mô tả chi tiết về sản phẩm"></textarea>
        </div>

        <!-- Button Group -->
        <div class="product-form__button-group">
            <button type="button" class="product-form__button product-form__button--cancel">Hủy</button>
            <button type="submit" class="product-form__button product-form__button--save">Lưu</button>
        </div>
    </form>
</div>

<script>
    const productType = document.getElementById('productType');
    const singlePriceField = document.getElementById('singlePriceField');
    const multipleSizeField = document.getElementById('multipleSizeField');

    productType.addEventListener('change', function() {
        if (this.value === 'single') {
            singlePriceField.style.display = 'block';
            multipleSizeField.style.display = 'none';
        } else if (this.value === 'multiple') {
            singlePriceField.style.display = 'none';
            multipleSizeField.style.display = 'block';
        } else {
            singlePriceField.style.display = 'none';
            multipleSizeField.style.display = 'none';
        }
    });
</script>

@endsection
