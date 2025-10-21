@extends('customer.layouts.myapp')
@section('title', 'Đăng nhập')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <section class="auth-section">
        <div class="auth-form">
            <h1 class="auth-title">ĐĂNG NHẬP TÀI KHOẢN</h1>
            <p class="auth-sub">
                Bạn chưa có tài khoản?
                <a href="{{ route('register') }}">Đăng kí tại đây</a>
            </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Mật khẩu')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember + Forgot -->
                <div class="mb-4 flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="mr-2"> Nhớ đăng nhập
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link">Quên mật khẩu?</a>
                    @endif
                </div>

                <!-- Button -->
                <x-primary-button class="btn-primary w-full justify-center">
                    {{ __('Đăng nhập') }}
                </x-primary-button>

            </form>
        </div>
    </section>
@endsection