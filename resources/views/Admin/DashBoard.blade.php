<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .topbar {
            width: 100%;
            height: 60px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-sizing: border-box;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            justify-content: space-between;
            z-index: 1;
        }

        .topbar .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }

        .topbar .logo i {
            margin-right: 10px;
            color: #5a5cff;
        }

        .topbar .container {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
        }

        .topbar .search {
            position: relative;
        }

        .topbar .search input {
            width: 200px;
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .topbar .notification,
        .topbar .mail,
        .topbar .hamburger {
            font-size: 18px;
            color: #666;
            cursor: pointer;
        }

        .topbar .hamburger {
            font-size: 24px;
            margin-left: 20px;
        }

        .sidebar {
            width: 250px;
            height: calc(100vh - 60px);
            background-color: #f8f9fa;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 60px;
            transition: transform 0.3s ease;
            transform: translateX(0);
            z-index: 2;
        }

        .sidebar.collapsed {
            width: 80px; /* Adjust width for collapsed state */
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            display: none; /* Hide in collapsed state */
        }

        .sidebar.collapsed .logo {
            display: none;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }

        nav {
            flex-grow: 1;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            padding: 10px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            color: #666;
        }

        li i {
            margin-right: 10px;
            width: 20px;
            font-size: 18px; /* Default icon size */
            transition: font-size 0.3s ease;
        }

        .sidebar.collapsed li i {
            font-size: 26px; /* Larger icon size when collapsed */
        }

        li span {
            display: inline; /* Show text in expanded state */
        }

        .sidebar.collapsed li span {
            display: none; /* Hide text in collapsed state */
        }

        li.active {
            color: #5a5cff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="logo">
            <i class="fas fa-credit-card"></i>
            <span>Bankdash</span>
            <div class="hamburger">
                <i class="fas fa-bars" style="color: black;"></i>
            </div>
        </div>
        <div class="container">
            <div class="search">
                <input type="text" placeholder="Search...">
            </div>
            <div class="notification">
                <i class="fas fa-bell"></i>
            </div>
            <div class="notification">
               <a href="{{route('home')}}">thoát</a>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <nav>
            <ul>
                <li class="active"><i class="fas fa-home"></i><span> Dashboard</span></li>
                <li><i class="fas fa-user"></i><span> Tài Khoản</span></li>
                <li><i class="fas fa-newspaper"></i><span> Tin tức</span></li>
                <li><i class="fas fa-check-circle"></i><span> Phê Duyệt</span></li>
                <li><i class="fas fa-plug"></i><span> Trạm Sạc</span></li>
                <li><i class="fas fa-envelope"></i><span> Email</span></li>
                <li><i class="fas fa-cog"></i><span> Cài Đặt</span></li>
                <li><i class="fas fa-cog"></i><span>
                    @auth
                        {{ Auth::user()->name }}
                    @else
                        Khách
                    @endauth
                </span></li>
            </ul>
        </nav>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.sidebar nav ul li');
            const toggleBtn = document.querySelector('.topbar .hamburger'); // Updated selector
            const sidebar = document.querySelector('.sidebar');

            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
        });
    </script>
</body>
</html>
