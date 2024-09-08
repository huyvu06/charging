@extends('nav.header')
@section('title', 'Quản lý Trạm Sạc')

@section('content')
<div class="container">
    <h1>Quản lý Trạm Sạc</h1>
    {{-- @if($stations->isEmpty())
        <p>Hiện tại bạn chưa đăng ký trạm sạc nào.</p>
    @else --}}
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Trạm Sạc</th>
                    <th>Địa Chỉ</th>
                    <th>Điện Thoại</th>
                    <th>Email</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($stations as $station)
                <tr>
                    <td>{{ $station->name }}</td>
                    <td>{{ $station->address }}</td>
                    <td>{{ $station->phone }}</td>
                    <td>{{ $station->email }}</td>
                    <td>
                        <a href="{{ route('station.show', $station->id_tramsac) }}" class="btn btn-info">Xem</a>
                        <a href="{{ route('station.edit', $station->id_tramsac) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('station.destroy', $station->id_tramsac) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
    {{-- @endif --}}
</div>
@endsection
