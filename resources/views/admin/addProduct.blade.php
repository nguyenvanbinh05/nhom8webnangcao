@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')
<div class="content__body">
    <h1 class="product-form__header">Thêm Sản Phẩm Mới</h1>
    <form class="product-form">
        <div class="product-form__group">
            <div class="product-form__field" id="productCode-form">
                <label class="product-form__label" for="productCode"><span style="color: red">* </span>Mã sản phẩm</label>
                <input class="product-form__input" type="text" id="productCode" name="productCode"
                    placeholder="Nhập mã sản phẩm">
            </div>

            <div class="product-form__field">
                <label class="product-form__label" for="productName"><span style="color: red">* </span>Tên sản phẩm</label>
                <input class="product-form__input" type="text" id="productName" name="productName"
                    placeholder="Nhập tên sản phẩm">
            </div>
        </div>

        <div class="product-form__group">
            <div class="product-form__field">
                <label class="product-form__label"><span style="color: red">* </span>Ảnh chính</label>
                <div class="product-form__image-box" id="mainImageBox">
                    <input class="product-form__file" type="file" id="mainImage" name="mainImage"
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
                        name="additionalImage[]" accept="image/*" multiple>
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
                <select class="product-form__input" id="brand" name="brand">
                    <option value="0">chọn loại</option>
                    <option value="ca_phe">coffee</option>
                    <option value="tra">tea</option>
                    <option value="banh">cake</option>
                </select>
            </div>

            <div class="product-form__field">
                <label class="product-form__label" for="price"><span style="color: red">* </span>Giá bán</label>
                <input class="product-form__input" type="number" id="price" name="price"
                    placeholder="Nhập giá bán">
            </div>
        </div>

        <div class="product-form__group">
            <div class="product-form__field-group">
                <div class="product-form__fieldchild">
                    <label class="product-form__label" for="unit"><span style="color: red">* </span>Đơn vị</label>
                    <select class="product-form__input" id="unit" name="unit">
                        <option value="chua_chon">Chọn</option>
                        <option value="coc">Cốc</option>
                        <option value="cai">Cái</option>
                    </select>
                </div>

                <div class="product-form__fieldchild" id="sizeField">
                    <label class="product-form__label">Size</label>
                    <div class="product-form__checkbox-group">
                        <label><input type="checkbox" name="size[]" value="S" checked> S</label>
                        <label><input type="checkbox" name="size[]" value="M" checked> M</label>
                        <label><input type="checkbox" name="size[]" value="L" checked> L</label>
                    </div>
                </div>
            </div>

            <div class="product-form__field">
                <label class="product-form__label" for="status"><span style="color: red">* </span>Trạng thái</label>
                <select class="product-form__select" id="status" name="status">
                    <option value="available">Còn hàng</option>
                    <option value="outOfStock">Chuẩn bị bán</option>
                    <option value="available">Ngưng kinh doanh</option>
                </select>
            </div>
        </div>

        <div class="product-form__field">
            <label class="product-form__label" for="detailedDescription"><span style="color: red">* </span>Mô tả chi tiết</label>
            <textarea class="product-form__textarea" id="detailedDescription" name="detailedDescription"
                placeholder="Mô tả chi tiết về sản phẩm"></textarea>
        </div>

        <div class="product-form__field">
            <label class="product-form__label" for="recipe"><span style="color: red">* </span>Nguyên liệu và công thức</label>
            <textarea class="product-form__textarea" id="recipe" name="recipe"
                placeholder="Nhập nguyên liệu cần dùng và công thức"></textarea>
        </div>

        <!-- Button Group -->
        <div class="product-form__button-group">
            <button type="button" class="product-form__button product-form__button--cancel">Hủy</button>
            <button type="submit" class="product-form__button product-form__button--save">Lưu</button>
        </div>
    </form>
@endsection