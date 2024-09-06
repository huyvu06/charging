@extends('nav.header')
@section('title', 'Hướng dẫn sử dụng trạm')
@section('content')

    <style>
        .step-container {
            margin-bottom: 30px;
        }

        .step-img {
            max-width: 100%;
            height: auto;
        }

        /* Alternating layout */
        .step-odd {
            padding-right: 0;
        }

        .step-even {
            padding-left: 0;
        }

        .text-center {
            padding: 40px;
        }
    </style>

    <!-- Steps Section -->
    <div class="container steps">
        <h3 class="text-center">Hướng Dẫn Sử Dụng</h3>

        <div class="row step-container">
            <div class="col-md-6 step-odd text-right">
                <h4>Bước 1:</h4>
                <p>Tải app</p>
            </div>
            <div class="col-md-6">
                <img src="{{asset('images/tram-sac-2.jpg')}}" class="step-img" alt="Step 1">
            </div>
        </div>

        <div class="row step-container">
            <div class="col-md-6 order-md-2 step-even text-left">
                <h4>Bước 2:</h4>
                <p>Đăng Ký</p>
            </div>
            <div class="col-md-6 order-md-1">
                <img src="{{asset('images/tram-sac-5.jpg')}}" class="step-img" alt="Step 2">
            </div>
        </div>

        <div class="row step-container">
            
            <div class="col-md-6 step-odd text-right">
                <h4>Bước 3:</h4>
                <p>Đăng Nhập</p>
            </div>
            <div class="col-md-6">
                <img src="{{asset('images/tram-sac-7.jpg')}}" class="step-img" alt="Step 3">
            </div>
        </div>

        <div class="text-center">
            <a href="#" class="btn btn-success"
                style="margin: 20px;
        text-align: center;box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        margin: 10px;">Tải
                App Ngay</a>
        </div>
    </div>
@endsection
