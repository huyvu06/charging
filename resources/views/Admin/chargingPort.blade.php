@extends('Admin.Dashboard')

@section('title', 'Cổng Sạc')

@section('content')
<div class="container mt-4">
    <h2>Danh Sách Cổng Sạc</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#addChargingPortModal">
        Thêm Cổng Sạc
    </button>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cổng Sạc</th>
                <th>Loại Xe</th>
                <th>Tùy Chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chargingPort as $port)
                <tr>
                    <td>{{ $port->id_charging_port }}</td>
                    <td>{{ $port->cong_sac }}</td>
                    <td>
                        @foreach ($port->cars as $car)
                            {{ $car->name }}
                            @if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        <a href="#editChargingPortModal{{ $port->id_charging_port }}" class="btn btn-primary btn-sm"
                            data-toggle="modal">Sửa</a>
                        <form action="{{ route('admin.deleteChargingPort', $port->id_charging_port) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa cổng sạc này không?')">Xóa</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal sửa cổng sạc -->
                <div class="modal fade" id="editChargingPortModal{{ $port->id_charging_port }}" tabindex="-1" role="dialog"
                    aria-labelledby="editChargingPortModalLabel{{ $port->id_charging_port }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editChargingPortModalLabel{{ $port->id_charging_port }}">Chỉnh
                                    sửa cổng sạc
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.updateChargingPort', $port->id_charging_port) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="cong_sac">Cổng Sạc:</label>
                                        <input type="text" name="cong_sac" class="form-control"
                                            value="{{ $port->cong_sac }}" required>
                                        @error('cong_sac')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="car_name">Tên Xe:</label>
                                        <input type="text" name="car_name" class="form-control"
                                            value="{{ $port->cars->pluck('name')->implode(', ') }}" required>
                                        @error('car_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <!-- Modal thêm cổng sạc -->
    <div class="modal fade" id="addChargingPortModal" tabindex="-1" role="dialog"
        aria-labelledby="addChargingPortModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addChargingPortModalLabel">Thêm Cổng Sạc Mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addChargingPort') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="cong_sac">Cổng Sạc:</label>
                            <input type="text" name="cong_sac" class="form-control" value="{{ old('cong_sac') }}"
                                required>
                            @error('cong_sac')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="car_name">Tên Xe:</label>
                            <input type="text" name="car_name" class="form-control" value="{{ old('car_name') }}"
                                placeholder="Nhập tên xe thứ 2 dùng dấu phẩy để ngăn cách bằng" required>
                            @error('car_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Thêm Cổng Sạc</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bao gồm các thư viện JS (chỉ cần cho modal Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection