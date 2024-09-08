@extends('nav.header')

@section('title', 'Login')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
            height: 100vh;
        }


        .container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row;
            overflow: hidden;
            width: 80%;
            max-width: 900px;
            padding: 40px;
            margin-bottom: 30px;
            margin-top: 30px;
        }

        /* Phần hình ảnh trong form */
        .image-container {
            flex: 1;
            padding-right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .form-container {
            flex: 1;
            padding-left: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 10px 10px 10px 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #7cb9e8;
        }

        .form-group input::placeholder {
            color: #999;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #999;
        }

        .form-group .fa-eye {
            right: 10px;
            left: auto;
            cursor: pointer;
            transform: translateY(-50%);
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
            background-color: #6aa7cf;
        }

        .create-account {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .create-account a {
            color: #333;
            text-decoration: none;
        }

        .create-account a:hover {
            text-decoration: underline;
        }

        .social-login {
            margin-top: 20px;
            text-align: center;
        }

        .social-login span {
            font-size: 14px;
            color: #666;
            margin-right: 10px;
        }

        .social-icons {
            display: inline-block;
        }

        .social-icons a {
            display: inline-block;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin: 0 5px;
            text-align: center;
            line-height: 35px;
            color: white;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .social-icons a:hover {
            opacity: 0.8;
        }

        .facebook {
            background-color: #3b5998;
        }

        .twitter {
            background-color: #1da1f2;
        }

        .google {
            background-color: #db4437;
        }

        /* Tùy chỉnh responsive cho thiết bị di động */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
                padding: 20px;
            }

            .image-container {
                padding: 0;
                margin-bottom: 20px;
            }

            .form-container {
                padding: 0;
            }
        }
    </style>

    <div class="container">
        <div class="image-container">
            <img src="{{ asset('images/login.jpg') }}" alt="Person working on laptop">
        </div>
        <div class="form-container">
            <h1>Login</h1>
        @if ($message = Session::get('error'))
           <div class="alert alert-danger alert-block">
	          
                <button type="button" class="close" data-dismiss="alert">×</button>	
        
               <strong>{{ $message }}</strong>
          </div>
          
     @endif
            <form action="" method="POST">
                @csrf
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" placeholder="Password" name="password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="remember" required>
                    <label for="remember" style="margin-top:6px">Remember me</label>
                </div>
                <button type="submit">Log in</button>
            </form>
            <div class="create-account">
                <a href="#">Create an account</a>
            </div>
            <div class="social-login">
                <span>Or login with</span>
                <div class="social-icons">
                    <a href="#" class="facebook">f</a>
                    <a href="#" class="twitter">t</a>
                    <a href="#" class="google">G</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = passwordField.nextElementSibling;
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            toggleIcon.classList.toggle('fa-eye-slash');
        }
    </script>
@endsection
