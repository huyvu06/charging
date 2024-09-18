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
        }

        /* Navbar styles */
        .navbar {
            background-color: #4a90e2; /* Updated color */
        }

        .navbar-brand {
            display: none; /* Hide the brand name */
        }

        .navbar-nav {
            flex-direction: row; /* Align items horizontally */
        }

        .navbar-nav .nav-link {
            color: #ffffff;
            font-size: 1.1em; /* Slightly larger font size */
        }

        .navbar-nav .nav-link:hover {
            color: #f1f1f1; /* Light gray for hover effect */
        }

        .navbar-nav .nav-item {
            margin-left: 15px; /* Space out nav items */
        }

        .navbar-toggler {
            border: none;
        }

        .content {
            margin-top: 56px; /* Adjust based on navbar height */
        }

        .container-fluid {
            padding: 20px;
        }

        .nav-icon {
            font-size: 1.3em; /* Larger icons */
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
    <nav class="navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.account') }}"><i class="fas fa-user nav-icon"></i> Tài khoản <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.news') }}"><i class="fas fa-newspaper nav-icon"></i> Tin tức</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.approval') }}"><i class="fas fa-check nav-icon"></i> Phê duyệt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cooperate') }}"><i class="fas fa-envelope nav-icon"></i> Đối Tác</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-bell nav-icon"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-sign-out-alt nav-icon"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    @yield('content')


</body> 

</html>
