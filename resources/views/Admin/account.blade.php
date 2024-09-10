@extends('Admin.Dashboard')

@section('title', 'User Accounts')

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
                <th>Tên</th>
                <th>Email</th>
                <th>Quyền</th>
                <th>Mật Khẩu</th>
                <th>Tùy Chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->password }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="#editUserModal{{ $user->user_id }}" class="btn btn-primary btn-sm"
                            data-toggle="modal">Sửa</a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.delete', $user->user_id) }}" method="POST" style="display:inline;">
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
                <div class="modal fade" id="editUserModal{{ $user->user_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editUserModalLabel{{ $user->user_id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel{{ $user->user_id }}">Chỉnh sửa người dùng
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.update', $user->user_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Tên:</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                            required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

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
                                            <option value="0" {{ old('role', $user->role) == '0' ? 'selected' : '' }}>0
                                            </option>
                                            <option value="1" {{ old('role', $user->role) == '1' ? 'selected' : '' }}>1
                                            </option>
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
                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
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
                            <label for="role">Quyền:</label>
                            <select name="role" class="form-control" required>
                                <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>0</option>
                                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>1</option>
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
</div>

<!-- Include JS libraries (only needed for Bootstrap modals) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
