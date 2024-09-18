@extends('nav.header')

@section('title', 'Xác thực token')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            padding: 20px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 20px;
        }

        .card-header {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }

        .form-group .text-danger {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            color: #e74c3c;
            margin-bottom: 20px;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">Xác thực Email</div>
            <p class="alert">Vui lòng kiểm tra email để nhận mã xác thực !</p>
            <div class="card-body">
                <form action="{{ route('verify') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="token">Nhập mã xác thực:</label>
                        <input type="text" id="token" name="token" class="form-control" required>
                        @error('token')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Xác thực</button>
                </form>
            </div>
        </div>
    </div>
@endsection
