@extends('nav.header')
@section('title', 'Quản lý Trạm Sạc')
<style>
    img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px; 
    }
</style>

@section('content')
<div class="container">
    <h1>Quản lý Trạm Sạc</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <p>Số lượng trạm sạc: {{ $stations->count() }}</p>
    @if($stations->isEmpty())
        <p>Hiện tại bạn chưa đăng ký trạm sạc nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Trạm Sạc</th>
                    <th>Địa Chỉ</th>
                    <th>Điện Thoại</th>
                    <th>Email</th>
                    <th>Hình Ảnh</th>
                    <th>Loại Cổng Sạc</th>
                    <th>Mã Cổng Sạc</th>
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
                    <td>{{ $station->loai_tram }}</td>
                    <td>{{ $station->loai_sac }}</td>
                    <td>{{ $station->status == 1 ? 'Đã xác nhận' : 'Chưa xác nhận' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
