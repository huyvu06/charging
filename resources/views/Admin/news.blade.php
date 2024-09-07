<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
            font-size: 2em;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            font-size: 1em;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn i {
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        thead {
            background-color: #007bff;
            color: #ffffff;
        }

        th, td {
            padding: 12px;
            text-align: center; /* Center align text in table cells */
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            font-weight: 600;
            border-bottom: 2px solid #007bff;
        }

        tbody tr {
            transition: background-color 0.3s ease;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e2e6ea;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center; /* Center align action buttons */
        }

        .action-buttons a {
            color: #007bff;
            text-decoration: none;
            font-size: 1.2em;
            margin: 0 5px;
        }

        .action-buttons a:hover {
            color: #0056b3;
        }

        .action-buttons .delete {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>News Table</h1>
        <a href="#" class="btn"><i class="fas fa-plus"></i>Thêm</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Hình Ảnh</th>
                    <th>Nội Dung</th>
                    <th>Bình Luận</th>
                    <th>Ngày Tạo</th>
                    <th>Ngày Cập Nhật</th>
                    <th>Tùy Chọn</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($news as $new)
                <tr>
                    <td>{{ $new->id_news }}</td>
                    <td>{{ $new->title }}</td>
                    <td>{{ $new->image }}</td>
                    <td>{{ $new->content ?? 'N/A' }}</td>
                    <td>{{ $new->binhluan ?? 'N/A' }}</td>
                    <td>{{ $new->created_at ?? 'N/A' }}</td>
                    <td>{{ $new->updated_at ?? 'N/A' }}</td>
                    <td class="action-buttons">
                        <a href="#" class="edit"><i class="fas fa-edit"></i>Sửa</a>
                        <a href="#" class="delete"><i class="fas fa-trash"></i>Xóa</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
