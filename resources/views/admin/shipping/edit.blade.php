@extends('layouts.layout_management')

@section('titlepage', 'Chỉnh sửa khu vực giao hàng')

@section('content')
    <div class="content_body">
        <div class="product-management">
            <div class="product-header">
                <h2>Chỉnh Sửa Khu Vực Giao Hàng</h2>
            </div>

            @include('admin.shipping.form', [
                'shipping' => $shipping,
                'provinces' => $provinces,
                'districts' => $districts,
                'wards' => $wards
            ])
        </div>
    </div>
@endsection