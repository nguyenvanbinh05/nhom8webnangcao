@extends('layouts.layout_management')

@section('titlepage', 'Chỉnh sửa nguyên liệu')

@section('content')
<div class="content_body">
    <div class="formEdit">
        <h2>Chỉnh sửa nguyên liệu</h2>

        <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên nguyên liệu <span style="color:red">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $ingredient->name) }}" required>
            </div>

            <div class="form-group">
                <label for="quantity">Số lượng <span style="color:red">*</span></label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $ingredient->quantity) }}" required>
            </div>

            <div class="form-group">
                <label for="unit">Đơn vị</label>
                <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit', $ingredient->unit) }}">
            </div>

            <div class="form-group">
                <label for="supplier_id">Nhà cung cấp</label>
                <select name="supplier_id" id="supplier_id" class="form-control">
                    <option value="">-- Chọn nhà cung cấp --</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $ingredient->supplier_id == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="import_date">Ngày nhập</label>
                <input type="date" name="import_date" id="import_date" class="form-control" value="{{ old('import_date', $ingredient->import_date) }}">
            </div>

            <div class="form-group">
                <label for="expiry_date">Hạn sử dụng</label>
                <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date', $ingredient->expiry_date) }}">
            </div>

            <div class="form-actions">
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
@endsection