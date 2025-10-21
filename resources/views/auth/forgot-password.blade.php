@extends('customer.layouts.myapp')
@section('title', 'Quên mật khẩu')

@push('styles')
    {{-- Nếu cần css riêng cho trang này --}}
    {{--
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}"> --}}
@endpush

@section('content')
    <section class="auth-section" style="max-width:560px;margin:40px auto;">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Quên mật khẩu? Không vấn đề gì! Chỉ cần cho chúng tôi biết địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn liên kết đặt lại mật khẩu để bạn có thể đặt mật khẩu mới.') }}
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </section>
@endsection