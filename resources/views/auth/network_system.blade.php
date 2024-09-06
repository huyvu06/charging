@extends('nav.header')

@section('title', 'Hệ thống mạng lưới')

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            margin-top: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: row;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            width: 80%;
            max-width: 1200px;
        }

        .img {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .img img {
            max-width: 100%;
            height: auto;
        }

        .form {
            flex: 1;
            padding: 20px;
        }

        .form h2 {
            margin-top: 0;
            position: relative;
            padding-bottom: 10px;
            padding-left: 80px;
        }

        .form h2::after {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background-color: #000;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .form label {
            display: block;
            margin: 10px 0 5px;
        }

        .form input,
        .form select,
        .form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .form button:hover {
            background-color: #0056b3;
        }

        /* Responsive cho thiết bị di động */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 95%;
            }

            .img {
                margin-bottom: 20px;
            }

            .form h2 {
                padding-left: 0;
                text-align: center;
            }

            .form h2::after {
                left: 0;
                width: 50%;
                margin: 0 auto;
                right: 0;
            }
        }
    </style>

    <div class="container">
        <div class="img">
            <img src="{{asset('images/map.jpg')}}" alt="Bản đồ Việt Nam">
        </div>
        <div class="form">
            <h2>Đăng Ký Trở Thành Đối Tác</h2>
            <form>
                <label for="name">Họ và tên:</label>
                <input type="text" id="name" name="name" required>

                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="region">Khu vực:</label>
                <select id="region" name="region">
                    <option value="north">Miền Bắc</option>
                    <option value="central">Miền Trung</option>
                    <option value="south">Miền Nam</option>
                </select>

                <button type="submit">GỬI ĐĂNG KÝ</button>
            </form>
        </div>
    </div>
@endsection
