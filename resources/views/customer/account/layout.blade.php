<!-- resources/views/customer/account/layout.blade.php -->
@extends('customer.layouts.myapp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endpush

@section('content')
    <section class="main-content account">
        <div class="account-wrap">
            <aside class="account-sidebar">
                <h3>TRANG TÀI KHOẢN</h3>
                <p>Xin chào, <strong>{{ auth()->user()->name }}</strong>!</p>

                @php $r = request()->route()->getName(); @endphp
                <nav>
                    <a href="{{ route('account.overview') }}"
                        class="{{ str_starts_with($r, 'account.overview') ? 'active' : '' }}">Thông tin tài khoản</a>
                    <a href="{{ route('account.orders') }}"
                        class="{{ str_starts_with($r, 'account.orders') ? 'active' : '' }}">Đơn hàng của bạn</a>
                    <a href="{{ route('account.password.form') }}"
                        class="{{ str_starts_with($r, 'account.password.form') ? 'active' : '' }}">Đổi mật khẩu</a>
                </nav>
            </aside>
            <section class="account-content">
                @yield('account')
            </section>
        </div>
    </section>
@endsection