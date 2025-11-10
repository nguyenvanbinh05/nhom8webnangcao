@extends('layouts.layout_management')

@section('titlepage', 'Thêm khu vực giao hàng')

@section('content')
    <div class="content_body">
        <div class="product-management">
            <div class="product-header">
                <h2>Thêm Khu Vực Giao Hàng</h2>
            </div>

            @include('admin.shipping.form', [
                'shipping' => null,
                'provinces' => $provinces,
                'districts' => [],
                'wards' => []
            ])
        </div>
    </div>
@endsection