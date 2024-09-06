@extends('nav.header')
@section('title', 'Introduce')
@section('content')

    <style>
        .header-image {
            background-image: url('../images/tram-sac-8.jpg');
            background-size: cover;
            /* Giữ tỷ lệ ảnh để bao phủ toàn bộ phần nền */
            background-position: center;
            background-repeat: no-repeat;
            height: 500px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .header-image h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
            /* Thêm đổ bóng để tăng độ rõ ràng */
        }

        .content-overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            /* Tăng độ tối cho nền */
            color: #fff;
            padding: 20px;
            box-shadow: 0px -5px 15px rgba(0, 0, 0, 0.5);
            /* Tạo hiệu ứng đổ bóng mềm mại cho phần overlay */
        }

        .content-overlay p {
            font-size: 1.2rem;
            line-height: 1.6;
            /* Tăng khoảng cách dòng để nội dung dễ đọc hơn */
        }

        .principles {
            background-color: #00bcd4;
            /* Màu xanh dương nhạt để tạo cảm giác chuyên nghiệp */
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: -20px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            /* Tạo bóng nhẹ để phần này nổi bật */
        }

        .principles h2 {
            margin-bottom: 10px;
            /* Tạo khoảng cách giữa tiêu đề và đoạn văn */
            font-size: 2rem;
            text-transform: uppercase;
            /* Chuyển tiêu đề sang chữ in hoa */
        }

        .principles p {
            margin: 0;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }
    </style>

    <!-- Header Section with Content Overlay -->
    <div class="header-image">
        <h1>GIỚI THIỆU VỀ TRẠM SẠC</h1>
        <div class="content-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Chúng tôi chuyên sửa chữa và bảo hành các dòng xe như: Audi, Acura, BMW, Porsche, Landrover
                            Jaguar, Rolls-Royce, Bentley... Với đội ngũ kỹ thuật viên chuyên nghiệp cùng trang thiết bị hiện
                            đại VIỆN AUTO là trung tâm sửa chữa ô tô uy tín được nhiều khách hàng biết đến trên cả nước.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Principles Section -->
    <div class="principles">
        <h2>5 TIÊU CHÍ VÀNG</h2>
        <p>INNOVATION - SUSTAINABLE - AGILITY - INTEGRITY - UNITY</p>
        <p>SÁNG TẠO - BỀN VỮNG - LINH HOẠT - LIÊM CHÍNH - ĐOÀN KẾT</p>
    </div>

@endsection
