<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home')</title> <!-- Hiển thị tiêu đề động -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .dropdown-menu {
            background-color: #f9f9f5;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            right: 0;
            left: auto;
            top: 100%;
            position: absolute;
        }

        .dropdown-menu .dropdown-item {
            color: #707862;
            padding: 10px 20px;
            font-size: 16px;
            text-align: left;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #e8e8e5;
            color: #50554a;
        }

        /* Thêm chuyển đổi mượt mà khi hover */
        .dropdown-menu .dropdown-item {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .map {
            padding-top: 20px;
            background-color: #8ff76e;
            padding: 20px;
            text-align: center;
        }

        .map iframe {
            width: 50%;
            height: 300px;
            border: none;
        }

        footer {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-dark " style="background-color: #a6df4c;">
        <a href="{{route('home')}}"><img src="{{asset('images/logo.jpg')}}" alt="" style="width: 80px; height:80px"></a>
        <div class="collapse navbar-collapse " id="collapsibleNavId">
            <ul class="navbar-nav mr-auto ms-3 mt-2 mt-lg-0 py-1">
                <li class="nav-item dropdown px-3">
                    <a class="nav-link dropdown-toggle" href="{{ asset('introduce') }}" id="dropdownId"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #707862;"> Giới
                        Thiệu </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="{{ asset('introduce') }}"> Về chúng tôi </a>
                        <a class="dropdown-item" href="{{ route('news') }}"> Tin tức </a>
                    </div>
                </li>

                <li class="nav-item dropdown pr-3">
                    <a class="nav-link dropdown-toggle" href="{{ asset('network_system') }}" id="dropdownId"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #707862;"> Dành
                        cho khách hàng </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="{{ route('map') }}"> Bản Đồ Trạm sạc </a>
                        <a class="dropdown-item" href="{{ asset('network_system') }}"> Hệ Thống Mạng Lưới </a>
                        <a class="dropdown-item" href="{{ route('user_manual') }}"> Hướng Dẫn Sự Dụng Trạm Sạc </a>
                    </div>
                </li>

                @auth
                @if (Auth::user()->role == 2)
                    <li class="nav-item dropdown pr-3">
                        <a class="nav-link dropdown-toggle" href="" id="dropdownId"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #707862;"> Dành
                            Cho Đối Tác </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="{{ asset('#') }}"> Giải Pháp Quản Lý </a>
                            <a class="dropdown-item" href="{{ route('tramsac') }}"> Đăng Ký Trạm Sạc </a>
                        </div>
                    </li>
                @endif
            @endauth
            
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#" style="color: #707862;">
                                Liên Hệ
                            </a>
                        </li>

                    </ul>
                </div>
            </ul>

            <!-- Search bar -->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
            
                <ul class="navbar-nav ml-auto">
                    @auth
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" style=" color: rgb(252, 253, 255); font-size: 20px" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->userProfile->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('show.profile') }}">Profile</a>
                
                           
                            @if (Auth::user()->role != 0)
                                <a class="dropdown-item" href="{{ route('tramsac.index') }}">Quản lý trạm sạc</a>
                            @endif
                
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('user.logout') }}">Đăng Xuất</a>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="btn btn-outline-light mr-2" href="{{ route('login') }}" role="button">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light" href="{{ route('sign') }}" role="button">Đăng ký</a>
                    </li>
                    @endauth
                </ul>
            </form>
            

    
        </div>
    </nav>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @yield('content')
    <!-- Map Section -->
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8856.147389309785!2d105.91165358341146!3d21.050632440496003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a9a0a78b480b%3A0xde012606025bd95e!2zVG_DoCBuaMOgIFbEg24gcGjDsm5nIFN5bXBob255!5e0!3m2!1svi!2s!4v1724589525756!5m2!1svi!2s"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>

    </div>
    <!-- Footer Section -->
    <footer>
        <p>Copyright 2024 © Trạm Sạc</p>
@auth
   <a href=""> {{auth()->user()->name}} </a> 
@endauth

    </footer>

</body>

</html>