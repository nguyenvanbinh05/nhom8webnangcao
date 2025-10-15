@extends('layouts.app') {{-- hoặc layout của bạn --}}
@section('title', 'Đăng ký tài khoản')

@section('content')
    <section class="auth-section">
        <div class="auth-card">
            <h1 class="auth-title">ĐĂNG KÍ TÀI KHOẢN</h1>
            <p class="auth-sub">
                Bạn đã có tài khoản?
                <a href="{{ route('login') }}">Đăng nhập tại đây</a>
            </p>

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="grid-2">
                    <div class="field">
                        <label for="last_name">Họ:</label>
                        <input id="last_name" name="last_name" type="text" placeholder="Họ" value="{{ old('last_name') }}">
                        @error('last_name') <small class="error">{{ $message }}</small> @enderror
                    </div>
                    <div class="field">
                        <label for="first_name">Tên:</label>
                        <input id="first_name" name="first_name" type="text" placeholder="Tên"
                            value="{{ old('first_name') }}">
                        @error('first_name') <small class="error">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="phone">Số điện thoại:</label>
                    <input id="phone" name="phone" type="tel" placeholder="Số điện thoại" value="{{ old('phone') }}">
                    @error('phone') <small class="error">{{ $message }}</small> @enderror
                </div>

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

                <div class="field">
                    <label for="password_confirmation">Xác nhận mật khẩu:</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="Nhập lại mật khẩu">
                </div>

                <button class="btn-primary" type="submit">Đăng ký</button>
            </form>
        </div>
    </section>
@endsection