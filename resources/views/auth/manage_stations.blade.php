@extends('nav.header')
@section('title', 'Quản lý Trạm Sạc')

@section('content')
<div class="container">
    <h1>Quản lý Trạm Sạc</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
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
                    <td>{{ $station->status == 1 ? 'Đã xác nhận' : 'Chưa xác nhận' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection