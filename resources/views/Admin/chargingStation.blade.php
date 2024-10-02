@extends('Admin.Dashboard')

@section('title', 'Quản Lý Trạm Sạc')

@section('content')
<div class="container mt-4">
    <h2>Table Trạm Sạc</h2>

    <!-- Display Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Charging Station Button -->
    <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#addChargingStationModal">
        Thêm Trạm Sạc
    </button>

    <!-- Charging Stations Table -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Trạm Sạc</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Địa Chỉ</th>
                <th>Hình Ảnh</th>
                <th>Nội Dung</th>
                <th>Vĩ Độ</th>
                <th>Kinh Độ</th>
                <th>Tùy Chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tramSacs as $tramSac)
                <tr>
                    <td>{{ $tramSac->id_tramsac }}</td>
                    <td>{{ $tramSac->name_tramsac }}</td>
                    <td>{{ $tramSac->email }}</td>
                    <td>{{ $tramSac->phone }}</td>
                    <td>{{ $tramSac->address }}</td>
                    <td>
                        @if ($tramSac->image)
                            <img src="{{ asset('storage/' . $tramSac->image) }}" alt="Trạm Sạc Hình Ảnh"
                                 style="width: 50px; height: 50px;">
                        @else
                            <span>Không có hình ảnh</span>
                        @endif
                    </td>
                    <td>{{ $tramSac->content }}</td>
                    <td>{{ $tramSac->map_lat }}</td>
                    <td>{{ $tramSac->map_lon }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="#editChargingStationModal{{ $tramSac->id_tramsac }}" class="btn btn-primary btn-sm" data-toggle="modal">Sửa</a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.deleteChargingStation', $tramSac->id_tramsac) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa trạm sạc này không?')">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Charging Station Modal -->
                <div class="modal fade" id="editChargingStationModal{{ $tramSac->id_tramsac }}" tabindex="-1" role="dialog"
                     aria-labelledby="editChargingStationModalLabel{{ $tramSac->id_tramsac }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editChargingStationModalLabel{{ $tramSac->id_tramsac }}">Chỉnh sửa Trạm Sạc</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.updateChargingStation', $tramSac->id_tramsac) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="name_tramsac">Tên Trạm Sạc:</label>
                                        <input type="text" name="name_tramsac" class="form-control" value="{{ $tramSac->name_tramsac }}" required>
                                        @error('name_tramsac')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" class="form-control" value="{{ $tramSac->email }}" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">SĐT:</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $tramSac->phone }}" required>
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Địa Chỉ:</label>
                                        <input type="text" name="address" class="form-control" value="{{ $tramSac->address }}" required>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="content">Nội Dung:</label>
                                        <textarea name="content" class="form-control" required>{{ $tramSac->content }}</textarea>
                                        @error('content')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Hình Ảnh (Để trống nếu không thay đổi):</label>
                                        <input type="file" name="image" class="form-control">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="map_lat">Vĩ Độ:</label>
                                        <input type="text" name="map_lat" class="form-control" value="{{ $tramSac->map_lat }}" required>
                                        @error('map_lat')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="map_lon">Kinh Độ:</label>
                                        <input type="text" name="map_lon" class="form-control" value="{{ $tramSac->map_lon }}" required>
                                        @error('map_lon')
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

    <!-- Add Charging Station Modal -->
    <div class="modal fade" id="addChargingStationModal" tabindex="-1" role="dialog" aria-labelledby="addChargingStationModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addChargingStationModalLabel">Thêm Trạm Sạc Mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addChargingStation') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name_tramsac">Tên Trạm Sạc:</label>
                            <input type="text" name="name_tramsac" class="form-control" value="{{ old('name_tramsac') }}" required>
                            @error('name_tramsac')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">SĐT:</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Địa Chỉ:</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Nội Dung:</label>
                            <textarea name="content" class="form-control" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Hình Ảnh:</label>
                            <input type="file" name="image" class="form-control">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="map_lat">Vĩ Độ:</label>
                            <input type="text" name="map_lat" class="form-control" value="{{ old('map_lat') }}" required>
                            @error('map_lat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="map_lon">Kinh Độ:</label>
                            <input type="text" name="map_lon" class="form-control" value="{{ old('map_lon') }}" required>
                            @error('map_lon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success mt-2">Thêm Trạm Sạc</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
