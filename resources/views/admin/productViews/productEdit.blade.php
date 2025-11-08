@extends('layouts.layout_management')
@section('content')

<div class="content__body">
    <h1 class="title">Cập nhật sản phẩm</h1>

    <!-- Sau <h1>Cập nhật sản phẩm</h1> thêm khối thông báo lỗi -->
    @if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 15px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="{{ route('adminProduct.update', $product->idProduct) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tên sản phẩm -->
        <div class="product-form__group">
            <div class="product-form__field">
                <label class="product-form__label" for="productName"><span style="color: red">* </span>Tên sản phẩm</label>
                <input class="product-form__input" type="text" id="productName" name="NameProduct"
                    value="{{ old('NameProduct', $product->NameProduct) }}">
            </div>
        </div>

        <!-- Ảnh chính -->
        <div class="product-form__field">
            <label class="product-form__label">Ảnh chính</label>
            <input type="file" id="mainImage" name="MainImage" accept="image/*">
            <div style="margin-top:10px;">
                <img id="mainImagePreview"
                    src="{{ asset('storage/' . $product->MainImage) }}"
                    style="max-width:150px; display:block;">
            </div>
        </div>

        <!-- Ảnh phụ -->
        <div class="product-form__field" style="margin-top:20px">
            <label class="product-form__label">Ảnh phụ</label>
            <input type="file" id="additionalImage" name="additionalImages[]" accept="image/*" multiple>
            <div id="additionalImagesPreview" style="margin-top:10px;">
                @if($product->additationImages && $product->additationImages->count())
                @foreach($product->additationImages as $img)
                <img src="{{ asset('storage/' . $img->AdditationLink) }}"
                    class="existing-additional"
                    style="max-width:100px; margin-right:5px;">
                @endforeach
                @endif
            </div>
        </div>

        <!-- Loại sản phẩm -->
        <div class="product-form__group">
            <div class="product-form__field">
                <label class="product-form__label" for="brand"><span style="color: red">* </span>Loại sản phẩm</label>
                <select class="product-form__input" id="brand" name="CategoryId">
                    @foreach($categories as $category)
                    <option value="{{ $category->idCategory }}" {{ $product->CategoryId == $category->idCategory ? 'selected' : '' }}>
                        {{ $category->NameCategory }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Quản lý giá bán -->
        <div class="product-form__field">
            <label class="product-form__label" for="productType"><span style="color: red">*</span> Quản lý giá bán</label>
            <select class="product-form__input" id="productType" name="productType" required>
                <option value="">-- Chọn loại --</option>
                <option value="single" {{ $product->Price && !$product->sizes->count() ? 'selected' : '' }}>1 size / giá cố định</option>
                <option value="multiple" {{ $product->sizes->count() ? 'selected' : '' }}>Nhiều size</option>
            </select>
        </div>

        <!-- Giá cố định -->
        <div class="product-form__field {{ ($product->Price && (!$product->sizes || !$product->sizes->count())) ? '' : 'p-none' }}" id="singlePriceField">
            <label class="product-form__label" for="price"><span style="color:red">*</span> Giá bán</label>
            <input class="product-form__input" type="number" id="price" name="Price"
                value="{{ old('Price', $product->Price) }}" placeholder="Nhập giá bán">
        </div>

        <!-- Nhiều size -->
        <div class="product-form__group {{ ($product->sizes && $product->sizes->count()) ? '' : 'p-none' }}" id="multipleSizeField">
            <label class="product-form__label">Chọn size và nhập giá</label>
            <div class="product-form__checkbox-group">
                @php
                $sizesList = ['S', 'M', 'L'];
                @endphp

                @foreach($sizesList as $index => $size)
                @php
                // Lấy dữ liệu size từ database nếu có
                $sizeData = $product->sizes->firstWhere('Size', $size);
                @endphp
                <div class="size-item mb-2">
                    <input type="checkbox" name="sizes[{{ $index }}][Size]" value="{{ $size }}"
                        {{ $sizeData ? 'checked' : '' }}> {{ $size }}
                    <input type="number" name="sizes[{{ $index }}][Price]]"
                        placeholder="Giá {{ $size }}" class="product-form__input"
                        value="{{ $sizeData ? $sizeData->Price : '' }}">
                </div>
                @endforeach
            </div>
        </div>
        <!-- Trạng thái -->
        <div class="product-form__field">
            <label class="product-form__label" for="status"><span style="color: red">* </span>Trạng thái</label>
            <select class="product-form__select" id="status" name="Status">
                <option value="Available" {{ $product->Status == 'Available' ? 'selected' : '' }}>Sẵn sàng</option>
                <option value="Stopped" {{ $product->Status == 'Stopped' ? 'selected' : '' }}>Ngừng kinh doanh</option>
            </select>
        </div>

        <!-- Mô tả chi tiết -->
        <div class="product-form__field">
            <label class="product-form__label" for="detailedDescription"><span style="color: red">* </span>Mô tả chi tiết</label>
            <textarea class="product-form__textarea" id="detailedDescription" name="Description"
                placeholder="Mô tả chi tiết về sản phẩm">{{ old('Description', $product->Description) }}</textarea>
        </div>

        <!-- Button Group -->
        <div class="product-form__button-group">
            <a href="{{ route('adminProduct.index') }}" class="product-form__button product-form__button--cancel">Hủy</a>
            <button type="submit" class="product-form__button product-form__button--save">Lưu</button>
        </div>
    </form>
</div>

<script src="{{ asset('js/product-form-handler.js') }}"></script>

@endsection