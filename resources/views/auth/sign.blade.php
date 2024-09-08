@extends('nav.header')

@section('title', 'sign')

@section('content')
    <style>body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #f5f5f5;
    }

    .main-content {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px; /* Thêm khoảng cách ở phần trên và dưới để tránh lỗi hiển thị */
    }

    .container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        display: flex;
        width: 100%;
        max-width: 900px;
        overflow: hidden;
        flex-direction: row; /* Căn chỉnh mặc định thành hàng ngang */
    }

    .form-container {
        flex: 1;
        padding: 40px;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group input {
        width: 100%;
        padding: 12px 35px; /* Thêm khoảng trống cho icon */
        border: none;
        border-bottom: 2px solid #ddd;
        outline: none;
        font-size: 16px;
        color: #333;
    }

    .form-group input::placeholder {
        color: #999;
    }

    .form-group i {
        position: absolute;
        top: 50%;
        /* left: 10px; */
        transform: translateY(-50%);
        color: #999;
    }

    .form-group .toggle-password {
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .checkbox-group input {
        margin-right: 10px;
    }

    .checkbox-group label {
        font-size: 14px;
        color: #666;
    }

    button {
        background-color: #7cb9e8;
        color: white;
        border: none;
        padding: 12px 0;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #66a5cc;
    }

    .image-container {
        flex: 1;
        text-align: center;
        padding: 20px 40px 0 40px;
        border-radius: 0 10px 10px 0;
    }

    .image-container img {
        width: 100%;
        max-width: 300px;
        border-radius: 10px;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #666;
    }

    .login-link a {
        color: #7cb9e8;
        text-decoration: none;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container {
            flex-direction: column; /* Thay đổi thành cột trên màn hình nhỏ */
            max-width: 100%;
            border-radius: 0;
            box-shadow: none;
        }

        .image-container {
            border-radius: 0;
            padding: 20px;
        }

        .form-container {
            padding: 20px;
        }
    }
    </style>

    <!-- Main Content Section -->
    <div class="main-content">
        <div class="container">
            <div class="form-container">
                <h1>Register</h1>
                <form method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Your Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Your Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" placeholder="Password" name="password" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="repeat-password" placeholder="Repeat your password" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('repeat-password')"></i>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" required>
                        <label for="terms" style="margin-top:6px">I agree all statements in <a href="#">Terms of service</a></label>
                    </div>
                    <button type="submit">Register</button>
                </form>
            </div>
            <div class="image-container">
                <img src="{{ asset('images/register.jpg') }}" alt="Sign up image">
                <div class="login-link">
                    <a href="#">I am already member</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id = 'password') {
            const passwordField = document.getElementById(id);
            const toggleIcon = passwordField.nextElementSibling;
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            toggleIcon.classList.toggle('fa-eye-slash');
        }
    </script>
@endsection
