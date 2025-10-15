@extends('costumer.layouts.myapp')
@section('title', 'Coffee Shop')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    @include('costumer.partials.hero')
    @include('costumer.partials.about')
    @include('costumer.partials.popular-products')
    @include('costumer.partials.contact')
@endsection