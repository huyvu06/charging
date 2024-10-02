@extends('Admin.Dashboard')
@section('title', 'Hệ Thống Đối Tác')
@section('content')
<div class="container mt-4">
    <h2>Table Mạng Hệ Thống</h2>

    <!-- Display Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Network Button -->
    <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#addNetworkModal">
        Thêm Mạng Hệ Thống
    </button>

    <!-- Networks Table -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Khu Vực</th>
                <th>Tùy Chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach($networks as $network)
                <tr>
                    <td>{{ $network->id_doitac }}</td>
                    <td>{{ $network->name }}</td>
                    <td>{{ $network->phone }}</td>
                    <td>{{ $network->email }}</td>
                    <td>{{ $network->khuvuc }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="#editNetworkModal{{ $network->id_doitac }}" class="btn btn-primary btn-sm" data-toggle="modal">Sửa</a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.delete', $network->id_doitac) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa mạng này không?')">Xóa</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Network Modal -->
                <div class="modal fade" id="editNetworkModal{{ $network->id_doitac }}" tabindex="-1" role="dialog" aria-labelledby="editNetworkModalLabel{{ $network->id_doitac }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editNetworkModalLabel{{ $network->id_doitac }}">Chỉnh sửa Mạng Hệ Thống</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.update', $network->id_doitac) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Tên:</label>
                                        <input type="text" name="name" class="form-control" value="{{ $network->name }}" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Số Điện Thoại:</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $network->phone }}" required>
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" class="form-control" value="{{ $network->email }}" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="khuvuc">Khu Vực:</label>
                                        <select name="khuvuc" class="form-control" required>
                                            <option value="bắc" {{ $network->khuvuc == 'bắc' ? 'selected' : '' }}>Miền Bắc</option>
                                            <option value="trung" {{ $network->khuvuc == 'trung' ? 'selected' : '' }}>Miền Trung</option>
                                            <option value="nam" {{ $network->khuvuc == 'nam' ? 'selected' : '' }}>Miền Nam</option>
                                        </select>
                                        @error('khuvuc')
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

    <!-- Add Network Modal -->
    <div class="modal fade" id="addNetworkModal" tabindex="-1" role="dialog" aria-labelledby="addNetworkModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNetworkModalLabel">Thêm Mạng Hệ Thống Mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên:</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Số Điện Thoại:</label>
                            <input type="text" name="phone" class="form-control" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="khuvuc">Khu Vực:</label>
                            <select name="khuvuc" class="form-control" required>
                                <option value="bắc">Miền Bắc</option>
                                <option value="trung">Miền Trung</option>
                                <option value="nam">Miền Nam</option>
                            </select>
                            @error('khuvuc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success mt-2">Thêm Mạng Hệ Thống</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include JS libraries (only needed for Bootstrap modals) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection