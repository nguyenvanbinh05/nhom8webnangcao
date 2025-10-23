@extends('customer.layouts.myapp')
@section('title', 'Đăng kí')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <section class="register">
        <div class="auth-form">
            <h1 class="auth-title">ĐĂNG KÍ TÀI KHOẢN</h1>
            <p class="auth-sub">
                Bạn đã có tài khoản?
                <a href="{{ route('login') }}">Đăng nhập tại đây</a>
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Họ và tên (từ name) -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Họ và tên')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                        autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="error" />
                </div>

                <!-- Số điện thoại -->
                <div class="mb-4">
                    <x-input-label for="phone" :value="__('Số điện thoại')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')"
                        required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone')" class="error" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error" />
                </div>

                <!-- Mật khẩu -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Mật khẩu')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="error" />
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="error" />
                </div>

                <!-- Nút đăng ký -->
                <x-primary-button class="btn-primary w-full justify-center">
                    {{ __('Đăng kí') }}
                </x-primary-button>
            </form>
        </div>
    </section>
@endsection