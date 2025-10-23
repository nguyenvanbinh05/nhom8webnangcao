<!-- resources/views/customer/account/overview.blade.php -->
@extends('customer.account.layout')

@section('account')
    <h2>THÔNG TIN TÀI KHOẢN</h2>
    <p class="p"><strong>Họ tên:</strong> {{ $user->name }}</p>
    <p class="p"><strong>Email:</strong> {{ $user->email }}</p>
    <p class="p"><strong>SĐT:</strong> {{ $user->phone }}</p>

    @if($lastOrder)
        <p class="p"><strong>Địa chỉ gần nhất:</strong> {{ $lastOrder->address }}</p>
    @else
        <p class="muted p">Chưa có đơn hàng.</p>
    @endif
@endsection