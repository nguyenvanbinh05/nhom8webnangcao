@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')
<div class="content__body">
    <div class="content__header">
        <!-- Action buttons -->
        <a href="#" class="buttonAddForm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm mới</span>
        </a>

    </div>

    <!-- Table -->
    <table class="table">
        <thead class="table__head">
            <tr class="table__row">
                <th class="table__cell">Stt</th>
                <th class="table__cell">Tên danh mục</th>
                <th class="table__cell">Mô tả ngắn</th>
                <th class="table__cell">Số lượng sản phẩm</th>
                <th class="table__cell">Trạng thái</th>
                <th class="table__cell">Hành động</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <tr class="table__row">
                <td class="table__cell">1</td>
                <td class="table__cell order">Cà phê</td>
                <td class="table__cell">Các loại cà phê pha</td>
                <td class="table__cell">18</td>
                <td class="table__cell"><span class="status status--success">Sẵn sàng</span></td>
                <td class="table__cell actions">
                    <button class="actions__btn"><i class="fa-solid fa-pen-to-square actions__icon"></i></button>
                    <button class="actions__btn"><i class="fa-solid fa-trash actions__icon"></i></button>
                </td>
            </tr>
            <tr class="table__row">
                <td class="table__cell">2</td>
                <td class="table__cell order">Trà sữa</td>
                <td class="table__cell">Trà sữa nhiều hương vị</td>
                <td class="table__cell">12</td>
                <td class="table__cell"><span class="status status--success">Sẵn sàng</span></td>
                <td class="table__cell actions">
                    <button class="actions__btn"><i class="fa-solid fa-pen-to-square actions__icon"></i></button>
                    <button class="actions__btn"><i class="fa-solid fa-trash actions__icon"></i></button>
                </td>
            </tr>
            <tr class="table__row">
                <td class="table__cell">3</td>
                <td class="table__cell order">Bánh ngọt</td>
                <td class="table__cell">Bánh ngọt ăn kèm</td>
                <td class="table__cell">7</td>
                <td class="table__cell"><span class="status status--warning">sẵn sàng</span></td>
                <td class="table__cell actions">
                    <button class="actions__btn"><i class="fa-solid fa-pen-to-square actions__icon"></i></button>
                    <button class="actions__btn"><i class="fa-solid fa-trash actions__icon"></i></button>
                </td>
            </tr>
            <tr class="table__row">
                <td class="table__cell">4</td>
                <td class="table__cell order">Sinh tố</td>
                <td class="table__cell">Nước ép và sinh tố hoa quả</td>
                <td class="table__cell">9</td>
                <td class="table__cell"><span class="status status--success">Tạm ngưng</span></td>
                <td class="table__cell actions">
                    <button class="actions__btn"><i class="fa-solid fa-pen-to-square actions__icon"></i></button>
                    <button class="actions__btn"><i class="fa-solid fa-trash actions__icon"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>


<!-- form thêm mới danh mục -->
<div class="formInput" id="categoryAddForm">
    <div class="overlay" id="overlay">
        <form class="formContent" id="categoryAdd__form">
            <h2>Thêm mới danh mục</h2>
            
            <div class="form-group">
                <label for="name">Tên danh mục <span style="color:red">*</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên danh mục" required>
            </div>
            
            <div class="form-group">
                <label for="description">Mô tả ngắn</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Nhập mô tả ngắn..."></textarea>
            </div>
            
            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select id="status" name="status" class="form-control">
                    <option value="1" selected>Sẵn sàng</option>
                    <option value="0">Tạm ngưng</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-primary btnCloseForm">Hủy</button>
                <button type="submit" class="btn btn-secondary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>
@endsection