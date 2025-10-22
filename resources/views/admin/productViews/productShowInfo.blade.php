@extends('layouts.layout_management')

@section('titlepage', 'coffee')

@section('content')
<div class="admin-product-detail-container">

    <div class="admin-product-detail-header">
        <h2>Quản lý sản phẩm</h2>
        <p>Trang chi tiết sản phẩm</p>
    </div>

    <div class="admin-product-detail-card">
        <div class="apd-left">
            <img src="{{ asset('storage/' . $product->MainImage) }}"
                alt="{{ $product->NameProduct }}" class="apd-main-img">

            <h3 class="apd-subtitle">Ảnh phụ</h3>
            <div class="apd-sub-images">
                @forelse($product->additationImages as $image)
                <img src="{{ asset('storage/' . $image->AdditationLink) }}" alt="Ảnh phụ">
                @empty
                <p>Không có ảnh phụ</p>
                @endforelse
            </div>
        </div>

        <div class="apd-right">
            <h3 class="apd-product-name">{{ $product->NameProduct }}</h3>

            <table class="apd-info-table">
                <tr>
                    <th>Mã sản phẩm:</th>
                    <td>{{ $product->idProduct }}</td>
                </tr>
                <tr>
                    <th>Tên sản phẩm:</th>
                    <td>{{ $product->NameProduct }}</td>
                </tr>
                <tr>
                    <th>Danh mục:</th>
                    <td>{{ $product->category->NameCategory ?? 'Không có' }}</td>
                </tr>
                @if($product->Price)
                <tr>
                    <th>Giá bán:</th>
                    <td>{{ number_format($product->Price,0,',','.') }}đ</td>
                </tr>
                @endif
                <tr>
                    <th>Trạng thái:</th>
                    <td>
                        <span class="apd-badge {{ $product->Status ? 'apd-badge-success' : 'apd-badge-inactive' }}">
                            {{ $product->Status ? 'Đang bán' : 'Ngừng bán' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Mô tả:</th>
                    <td>{{ $product->Description }}</td>
                </tr>
            </table>

            <h4 class="apd-subtitle">Danh sách kích cỡ</h4>
            @if($product->sizes->count() > 0)
            <table class="apd-size-table">
                <thead>
                    <tr>
                        <th>Kích cỡ</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->sizes as $size)
                    <tr>
                        <td>{{ $size->Size }}</td>
                        <td>{{ number_format($size->Price,0,',','.') }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Không có kích cỡ nào.</p>
            @endif

            <div class="apd-action-buttons">
                <a href="{{ route('adminProduct.index') }}" class="apd-btn apd-btn-back">← Quay lại</a>
                <a href="{{ route('adminProduct.edit', $product->idProduct) }}" class="apd-btn apd-btn-edit">✎ Sửa sản phẩm</a>
            </div>
        </div>
    </div>
</div>
@endsection