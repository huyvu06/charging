<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>AdminLTE 2 | Log in</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .login-box {
            width: 360px;
            margin: 7% auto;
            padding: 15px;
            background: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-logo a {
            font-size: 2rem;
            font-weight: bold;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .social-auth-links {
            margin: 20px 0;
        }
        .social-auth-links a {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>LTE</a>
            @if(session('err'))
    <div class="alert alert-danger">
        {{ session('err') }}
    </div>
@endif
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="{{route('admin.logon')}}" method="post">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" name="email" required />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" required />
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" />
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-facebook">
                    <i class="fab fa-facebook-f"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-google">
                    <i class="fab fa-google"></i> Sign in using Google
                </a>
            </div>

            <p class="mb-1">
                <a href="#">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="register.html" class="text-center">Register a new membership</a>
            </p>
        </div>
    </div>

    <!-- jQuery and Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
