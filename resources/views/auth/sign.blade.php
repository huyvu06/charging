@extends('nav.header')

@section('title', 'Đăng ký')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #f5f5f5;
    }

    .main-content {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        /* Thêm khoảng cách ở phần trên và dưới để tránh lỗi hiển thị */
    }

    .container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        display: flex;
        width: 100%;
        max-width: 900px;
        overflow: hidden;
        flex-direction: row;
        /* Căn chỉnh mặc định thành hàng ngang */
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
        padding: 12px 35px;
        /* Thêm khoảng trống cho icon */
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
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Căn giữa theo chiều dọc */
        padding: 20px 40px 0 40px;
        border-radius: 0 10px 10px 0;
    }

    .image-container img {
        width: 100%;
        max-width: 300px;
        border-radius: 10px;
    }

    .login-link {
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

    /* Điều chỉnh cho các màn hình nhỏ */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            /* Thay đổi thành cột trên màn hình nhỏ */
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

    /* Styles for roles */
    #role {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        color: #333;
    }

    #role option {
        padding: 10px;
    }

    /* Styles for gender select */
    #sex {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        color: #333;
    }
</style>

<!-- Phần Nội Dung Chính -->
<div class="main-content">
    <div class="container">
        <div class="form-container">
            <h1>Đăng ký</h1>
            <form method="POST" action="{{ route('sign') }}" onsubmit="return validateForm()">
                @csrf

                <!-- Trường Tên -->
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Tên của bạn" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Trường Email -->
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email của bạn" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Trường Số Điện Thoại -->
                <div class="form-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" placeholder="Số điện thoại của bạn" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Trường Quyền -->
                <div class="form-group">
                    <label for="role">Chọn quyền : </label>
                    <select name="role" id="role" required>
                        <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>User</option>
                        <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Khách hàng</option>
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Trường Giới Tính -->
                <div class="form-group">
                    <label for="sex">Giới tính: </label>
                    <select name="sex" id="sex" required>
                        <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('sex')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" placeholder="Mật khẩu" name="password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="repeat-password" placeholder="Nhập lại mật khẩu" name="password_confirmation" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('repeat-password')"></i>
                </div>
                <!-- Điều khoản dịch vụ -->
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms" style="margin-top:6px">Tôi đồng ý với tất cả các điều khoản trong 
                        <a href="#">Điều khoản dịch vụ</a>
                    </label>
                </div>

                <!-- Nút gửi -->
                <button type="submit">Đăng ký</button>
            </form>
        </div>

        <div class="image-container">
            <img src="{{ asset('images/register.jpg') }}" alt="Hình ảnh đăng ký">
            <div class="login-link">
                <a href="{{ route('login') }}">Tôi đã có tài khoản</a>
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