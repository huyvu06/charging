@extends('nav.header')
@section('title', 'Tramsac')
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: #ffffff;
            text-align: center;
        }

        .form-container h1 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        .form-group textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive cho màn hình nhỏ */
        @media (max-width: 576px) {
            .form-container {
                padding: 20px;
                max-width: 90%;
            }

            .form-container h1 {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .form-group input,
            .form-group textarea {
                padding: 10px;
                font-size: 14px;
            }

            button {
                padding: 10px;
                font-size: 15px;
            }
        }
    </style>

    <div class="container">
        <form class="form-container">
            <h1>Đối Tác Chiến Lược</h1>
            <div class="form-group">
                <label for="name">Họ Và Tên(*):</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Số Điện Thoại(*):</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email(*):</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="name_tramsac">Tên Trạm Sạc(*):</label>
                <input type="text" id="name_tramsac" name="name_tramsac" required>
            </div>
            <div class="form-group">
                <label for="content">Nội Dung:</label>
                <input type="text" id="content" name="content">
            </div>
            <div class="form-group">
                <label for="map">Kinh Độ & Vĩ Độ:</label>
                <input type="text" id="map" name="map">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <textarea id="address" name="address" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>
@endsection
