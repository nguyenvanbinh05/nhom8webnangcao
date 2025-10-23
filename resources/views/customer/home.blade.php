@extends('customer.layouts.myapp')
@section('title', 'Coffee Shop')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    @include('customer.partials.hero')
    @include('customer.partials.about')
    {{-- @include('customer.partials.popular-products') --}}
    @include('customer.partials.contact')
@endsection