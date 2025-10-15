@extends('layouts.layout_management')

@section('titlepage', "coffee")

@section('content')
    <div class="overview">
        <div class="overview__box">
            <a href="#" class="overview__box--link">
                <!-- title -->
                <div class="box__header">
                    <span>Tổng doanh thu hôm nay</span>
                    <span class="box__change">+ 2%</span>
                </div>
                <!-- value -->
                <div class="box__value">
                    <i class="fa-solid fa-sack-dollar box__icon"></i>
                    <span>2.000.000đ</span>
                </div>
                <span>So với hôm qua</span>
            </a>
        </div>

        <div class="overview__box">
            <a href="#" class="overview__box--link">
                <!-- title -->
                <div class="box__header">
                    <span>Số lượng đơn hàng hôm nay</span>
                    <span class="box__change">+ 2%</span>
                </div>
                <!-- value -->
                <div class="box__value">
                    <i class="fa-solid fa-cart-shopping box__icon"></i>
                    <span>189</span>
                </div>
                <span>So với hôm qua</span>
            </a>
        </div>

        <div class="overview__box">
            <a href="#" class="overview__box--link">
                <!-- title -->
                <div class="box__header">
                    <span>Lượng người truy cập hôm nay</span>
                    <span class="box__change">+ 2%</span>
                </div>
                <!-- value -->
                <div class="box__value">
                    <i class="fa-solid fa-users box__icon"></i>
                    <span>189</span>
                </div>
                <span>So với hôm qua</span>
            </a>
        </div>

        <div class="overview__box">
            <a href="#" class="overview__box--link">
                <!-- title -->
                <div class="box__header">
                    <span>Doanh thu Tháng</span>
                    <span class="box__change">+ 2%</span>
                </div>
                <!-- value -->
                <div class="box__value">
                    <i class="fa-solid fa-chart-line box__icon"></i>
                    <span>2.000.000đ</span>
                </div>
            </a>
        </div>
    </div>
@endsection