@extends('nav.header')
@section('title', 'Quản lý Trạm Sạc')

<style>
    img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px; 
    }
    .container {
        max-width: 1200px; 
        margin: 0 auto; 
        padding: 20px; 
    }
    .table {
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 20px; 
        overflow-x: auto; 
    }
    .table th, .table td {
        padding: 15px; 
        border: 1px solid #ddd; 
        text-align: left; 
    }
    .table th {
        background-color: #f2f2f2; 
    }

    @media (max-width: 576px) {
        .table thead {
            display: none; /* Ẩn tiêu đề bảng trên màn hình nhỏ */
        }
        .table td {
            display: block; 
            width: 100%; 
            box-sizing: border-box; 
            padding: 10px; 
            position: relative; 
            text-align: left; 
            border: none; /* Bỏ border cho td để không bị đè lên */
        }
        .table td::before {
            content: attr(data-label); 
            position: absolute; 
            left: 10px; 
            width: auto; 
            padding-left: 10px; 
            text-align: left; 
            font-weight: bold; 
            color: #707862; 
            top: 0; 
            font-size: 12px; 
        }
    }
</style>

@section('content')
<div class="container">
    <div>
        <h1>Quản lý Trạm Sạc</h1>
        <div>
            <a class="btn btn-primary" href="{{ route('tramsac') }}" role="button">Đăng kí trạm sạc</a>
        </div>
        <p>Số lượng trạm sạc: {{ $stations->count() }}</p>
        @if($stations->isEmpty())
            <p>Hiện tại bạn chưa đăng ký trạm sạc nào.</p>
        @else
    </div>
   
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Tên Trạm Sạc</th>
                <th>Địa Chỉ</th>
                <th>Điện Thoại</th>
                <th>Email</th>
                <th>Hình Ảnh</th>
                <th>Cổng Sạc</th>
                <th>Loại Xe Hỗ Trợ</th> 
                <th>Trạng Thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stations as $station)
            <tr>
                <td>{{ $station->name_tramsac }}</td>
                <td>{{ $station->address }}</td>
                <td>{{ $station->phone }}</td>
                <td>{{ $station->email }}</td>
                <td>
                    @if($station->image)
                        <img src="data:image;base64,{{ $station->image }}" alt="image">
                    @else
                        Không có hình ảnh
                    @endif
                </td>
                <td>
                    {{ implode(', ', array_unique($station->chargingPort->pluck('cong_sac')->toArray())) }}
                </td>
                <td>
                    @foreach($station->chargingPort as $chargingPort)
                        <ul>
                            @foreach($chargingPort->cars as $car)
                                <li>{{ $car->name }}</li>
                            @endforeach
                        </ul>
                    @endforeach
                </td>
                <td>{{ $station->status == 1 ? 'Đã xác nhận' : 'Chưa xác nhận' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
