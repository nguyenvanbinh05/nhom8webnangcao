@extends('layouts.layout_management')

@section('titlepage', 'Quản lý khu vực giao hàng')

@section('content')
    <div class="content_body">
        <div class="product-management">
            <div class="product-header">
                <h2>Quản lý Khu Vực Giao Hàng</h2>
                <a href="{{ route('shipping.create') }}" class="product-form__button product-form__button--submit">
                    <i class="fas fa-plus"></i> Thêm khu vực
                </a>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="filter-section">
                <form method="GET" class="filter-form">
                    <div class="filter-item">
                        <input type="text" name="province" class="form-control" placeholder="Tìm tỉnh/thành phố..."
                            value="{{ request('province') }}" style="max-width: 300px;">
                    </div>
                    <div class="filter-item">
                        <select name="status" class="form-control" style="max-width: 200px;">
                            <option value="">-- Tất cả trạng thái --</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                ✓ Đang hoạt động
                            </option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                ✗ Vô hiệu hóa
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                    <a href="{{ route('shipping.index') }}" class="btn-reset">
                        <i class="fas fa-redo"></i> Xóa bộ lọc
                    </a>
                </form>
            </div>

            @if ($areas->count())
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-index">STT</th>
                                <th class="col-province">Tỉnh/Thành phố</th>
                                <th class="col-district">Quận/Huyện</th>
                                <th class="col-ward">Phường/Xã</th>
                                <th class="col-fee">Phí giao hàng</th>
                                <th class="col-status">Trạng thái</th>
                                <th class="col-action">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($areas as $index => $area)
                                <tr class="table-row">
                                    <td class="col-index text-center">
                                        {{ ($areas->currentPage() - 1) * $areas->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="col-province">
                                        <strong class="province-name">{{ $area->province_name }}</strong>
                                    </td>
                                    <td class="col-district">
                                        @if ($area->district_name)
                                            <span class="badge-text">{{ $area->district_name }}</span>
                                        @else
                                            <span class="text-muted text-small">(Toàn tỉnh)</span>
                                        @endif
                                    </td>
                                    <td class="col-ward">
                                        @if ($area->ward_name)
                                            <span class="badge-text">{{ $area->ward_name }}</span>
                                        @else
                                            <span class="text-muted text-small">(Toàn huyện)</span>
                                        @endif
                                    </td>
                                    <td class="col-fee text-center">
                                        @if ($area->shipping_cost === 0)
                                            <span class="badge badge-free">
                                                <i class="fas fa-check"></i> Miễn phí
                                            </span>
                                        @else
                                            <span class="badge badge-fee">
                                                {{ number_format($area->shipping_cost, 0, ',', '.') }}đ
                                            </span>
                                        @endif
                                    </td>
                                    <td class="col-status text-center">
                                        @if ($area->is_active)
                                            <span class="badge badge-active">
                                                <i class="fas fa-check-circle"></i> Hoạt động
                                            </span>
                                        @else
                                            <span class="badge badge-inactive">
                                                <i class="fas fa-times-circle"></i> Tắt
                                            </span>
                                        @endif
                                    </td>
                                    <td class="col-action text-center">
                                        <a href="{{ route('shipping.edit', $area) }}" class="action-btn edit-btn" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('shipping.destroy', $area) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn"
                                                onclick="return confirm('Xác nhận xóa khu vực này?')" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($areas->hasPages())
                    <div class="pagination-wrapper">
                        {{ $areas->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3>Chưa có khu vực giao hàng nào</h3>
                    <p>Hãy bắt đầu bằng cách thêm khu vực giao hàng được hỗ trợ</p>
                    <a href="{{ route('shipping.create') }}" class="product-form__button product-form__button--submit">
                        <i class="fas fa-plus"></i> Thêm khu vực
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .filter-section {
            background: white;
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-item {
            flex: 1;
            min-width: 200px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .product-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .product-header .product-form__button {
            margin: 0px 0 !important;
        }

        .btn-search {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }

        .btn-search:hover {
            background-color: #0056b3;
        }

        .btn-reset {
            padding: 8px 16px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }

        .btn-reset:hover {
            background-color: #545b62;
        }

        .table-container {
            background: white;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .data-table thead {
            background-color: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }

        .data-table th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #333;
            text-align: center
        }

        .data-table tbody tr {
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }

        .data-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .data-table td {
            padding: 12px 16px;
            vertical-align: middle;
            text-align: center
        }

        .col-index {
            width: 50px;
        }

        .col-province {
            width: 200px;
        }

        .col-district {
            width: 150px;
        }

        .col-ward {
            width: 150px;
        }

        .col-fee {
            width: 120px;
        }

        .col-status {
            width: 120px;
        }

        .col-action {
            width: 100px;
        }

        .text-center {
            text-align: center;
        }

        .province-name {
            font-size: 15px;
            color: #333;
        }

        .badge-text {
            display: inline-block;
            padding: 4px 8px;
            background-color: #e3f2fd;
            color: #1976d2;
            border-radius: 3px;
            font-size: 13px;
        }

        .text-muted {
            color: #999;
        }

        .text-small {
            font-size: 12px;
            font-style: italic;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-free {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-fee {
            background-color: #cfe2ff;
            color: #084298;
        }

        .badge-active {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .badge-inactive {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .action-btn {
            display: inline-block;
            width: 36px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            margin: 0 2px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .edit-btn {
            color: #ffc107;
            border-color: #ffc107;
        }

        .edit-btn:hover {
            background-color: #ffc107;
            color: white;
        }

        .delete-btn {
            color: #dc3545;
            border-color: #dc3545;
            background: none;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
        }

        .empty-icon {
            font-size: 64px;
            color: #ccc;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            color: #333;
            margin-bottom: 8px;
            font-size: 3rem;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 24px;
            font-size: 2rem;
        }

        .empty-state .fa-inbox {
            font-size: 10vw;
            color: #ccc;
            margin-bottom: 16px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }

        .product-form__button {
            padding: 8px 20px;
            max-width: 140px;
            font-size: 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            background-color: #0e4efc;
            margin: 0px auto;
        }
    </style>
@endsection