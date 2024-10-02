@extends('Admin.Dashboard')

@section('title', 'Quản Lý Tài Khoản')

@section('content')
<div class="container mt-4">
    <h2>Table User Accounts</h2>

    <!-- Display Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add User Button -->
    <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#addUserModal">
        Thêm
    </button>

    <!-- Users Table -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Quyền</th>
                <th>Mật Khẩu</th>
                <th>Tên</th>
                <th>SDT</th>
                <th>Địa Chỉ</th>
                <th>Hình Ảnh</th>
                <th>Giới Tính</th>
                <th>Tùy Chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 0) User
                        @elseif($user->role == 1) Admin
                        @elseif($user->role == 2) Khách hàng
                        @endif
                    </td>
                    <td>{{ $user->password ? '******' : 'Chưa có thông tin' }}</td>
                    <td>{{ $user->profile->name ?? 'Chưa có thông tin' }}</td>
                    <td>{{ $user->profile->phone ?? 'Chưa có thông tin' }}</td>
                    <td>{{ $user->profile->address ?? 'Chưa có thông tin' }}</td>
                    <td>
                        @if ($user->profile && $user->profile->image)
                            <img src="{{ asset('storage/' . $user->profile->image) }}" alt="User Image"
                                style="width: 50px; height: 50px;">
                        @else
                            <span>Không có hình ảnh</span>
                        @endif
                    </td>
                    <td>{{ $user->profile->sex ?? 'Chưa có thông tin' }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="#editUserModal{{ $user->id }}" class="btn btn-primary btn-sm" data-toggle="modal">Sửa</a>
                        <!-- Reset Password Button -->
                        <a href="#resetPasswordModal{{ $user->id }}" class="btn btn-warning btn-sm" data-toggle="modal">Đặt
                            lại mật khẩu</a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa người dùng này không?')">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Chỉnh sửa người dùng
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                            required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Quyền:</label>
                                        <select name="role" class="form-control" required>
                                            <option value="0" {{ old('role', $user->role) == '0' ? 'selected' : '' }}>User
                                            </option>
                                            <option value="1" {{ old('role', $user->role) == '1' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="2" {{ old('role', $user->role) == '2' ? 'selected' : '' }}>Khách
                                                hàng</option>
                                        </select>
                                        @error('role')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Mật khẩu (Để trống nếu không thay đổi):</label>
                                        <input type="password" name="password" class="form-control">
                                        @error('password')
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Thêm người dùng mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addUser') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role">Quyền:</label>
                            <select name="role" class="form-control" required>
                                <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>User</option>
                                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Khách hàng</option>
                            </select>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Thêm người dùng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Reset Password Modal -->
    @foreach($users as $user)
        <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="resetPasswordModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resetPasswordModalLabel{{ $user->id }}">Đặt lại mật khẩu người dùng
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.resetPassword', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="password">Mật khẩu mới:</label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-warning mt-2">Đặt lại mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Include JS libraries (only needed for Bootstrap modals) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @endsection