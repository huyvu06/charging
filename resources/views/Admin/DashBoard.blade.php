<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Xóa margin của body để không có khoảng trống */
            height: 100vh; /* Đảm bảo chiều cao đầy đủ cho body */
            display: flex; /* Sử dụng flex để dễ dàng quản lý layout */
        }

        /* Navbar styles */
        .navbar {
            background-color: #4a90e2; /* Updated color */
            position: fixed; /* Fix the navbar on the left */
            height: 100%; /* Full height */
            width: 200px; /* Set width of navbar */
            overflow-y: auto; /* Allow vertical scrolling if needed */
            top: 0; /* Đảm bảo navbar bắt đầu từ đầu trang */
            display: flex;
            flex-direction: column; /* Set navbar to vertical */
        }

        .navbar-brand {
            display: none; /* Hide the brand name */
        }

        .navbar-nav {
            flex-direction: column; /* Align items vertically */
            width: 100%; /* Full width */
            padding-top: 20px; /* Khoảng cách trên */
        }

        .navbar-nav .nav-link {
            color: #ffffff; /* Màu chữ */
            font-size: 1.1em; /* Slightly larger font size */
            text-align: left; /* Align text to the left */
        }

        .navbar-nav .nav-link:hover {
            color: #f1f1f1; /* Light gray for hover effect */
        }

        .navbar-nav .nav-item {
            margin: 10px 0; /* Space out nav items vertically */
        }

        .navbar-toggler {
            border: none; /* Remove border for toggler */
        }

        .content {
            margin-left: 220px; /* Adjust based on navbar width */
            margin-top: 0; /* Xóa khoảng cách trên cho nội dung chính */
            padding: 20px; /* Thêm padding cho nội dung chính */
            width: calc(100% - 220px); /* Đảm bảo chiều rộng nội dung chính */
        }

        .nav-icon {
            font-size: 1.3em; /* Larger icons */
        }

        /* Top right icons */
        .top-right {
            position: absolute; /* Đặt vị trí tuyệt đối để định vị chính xác */
            top: 20px; /* Khoảng cách từ trên cùng */
            right: 20px; /* Khoảng cách từ bên phải */
        }

        /* Style for the icon list */
        .navbar-nav.ml-auto {
            display: flex;
            align-items: center;
            margin-left: auto; /* Move icons to the right */
        }

        .navbar-nav.ml-auto .nav-item {
            margin-left: 10px; /* Space out icons */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.account') }}"><i class="fas fa-user nav-icon"></i> Tài khoản
                    <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.news') }}"><i class="fas fa-newspaper nav-icon"></i> Tin
                    tức</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.chargingStation') }}"><i class="fas fa-check nav-icon"></i> Trạm Sạc</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cooperate') }}"><i class="fas fa-envelope nav-icon"></i> Đối
                    Tác</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.chargingPort') }}"></i>Cổng Sạc</a>
            </li>
        </ul>
        <div class="top-right">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-bell nav-icon"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}"><i class="fas fa-sign-out-alt nav-icon"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
