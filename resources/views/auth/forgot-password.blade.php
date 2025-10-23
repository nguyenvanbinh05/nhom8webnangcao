@extends('customer.layouts.myapp')
@section('title', 'Quên mật khẩu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reset-pw.css') }}">
@endpush

@section('content')
    <section class="auth-section">
        <div class="desc">
            {{ __('Quên mật khẩu? Không vấn đề gì! Chỉ cần cho chúng tôi biết địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn liên kết đặt lại mật khẩu để bạn có thể đặt mật khẩu mới.') }}
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus class="input" />
                <x-input-error class="error" :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="btn-send">
                <x-primary-button>
                    {{ __('Gửi email link đặt lại mật khẩu') }}
                </x-primary-button>
            </div>
        </form>
    </section>
@endsection