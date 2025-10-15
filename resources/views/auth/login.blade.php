{{-- ví dụ: resources/views/auth/login.blade.php --}}
@extends('costumer.layouts.myapp') {{-- dùng layout sẵn có --}}
@section('title', 'Đăng nhập')

@push('styles')
    {{-- nếu bạn có CSS riêng cho trang auth --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <section class="auth-section">
        <h1 class="text-2xl font-semibold mb-4">Đăng nhập</h1>
        {{-- Giữ form Breeze, chỉ bọc bằng HTML/Classes của bạn --}}
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="form-input" />
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password" name="password" required class="form-input" />
                @error('password') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4 flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="mr-2"> Nhớ đăng nhập
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link">Quên mật khẩu?</a>
                @endif
            </div>

            <button class="btn-primary w-full">Đăng nhập</button>

            <p class="mt-4 text-sm">Chưa có tài khoản?
                <a href="{{ route('register') }}" class="link">Đăng ký</a>
            </p>
        </form>
    </section>
@endsection