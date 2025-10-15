@extends('layouts.app')
@section('title', 'Đăng nhập')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@section('content')
    <section class="auth-section">
        <div class="auth-card">
            <h1 class="auth-title">ĐĂNG NHẬP TÀI KHOẢN</h1>
            <p class="auth-sub">
                Bạn chưa có tài khoản?
                <a href="{{ route('register') }}">Đăng kí tại đây</a>
            </p>

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="field">
                    <label for="email">Email:</label>
                    <input id="email" name="email" type="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email') <small class="error">{{ $message }}</small> @enderror
                </div>

                <div class="field">
                    <label for="password">Mật khẩu:</label>
                    <input id="password" name="password" type="password" placeholder="Mật khẩu">
                    @error('password') <small class="error">{{ $message }}</small> @enderror
                </div>

                <div class="field-inline">
                    <label class="remember"><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label>
                    <a class="forgot" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                </div>

                <button class="btn-primary" type="submit">Đăng nhập</button>
            </form>
        </div>
    </section>
@endsection