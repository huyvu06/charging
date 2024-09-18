@extends('nav.header')

@section('title', 'Thông tin cá nhân')

@section('content')

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #e9ecef;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 50vh;
        padding: 20px;
    }

    .card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 900px;
        width: 100%;
        position: relative;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 24px;
        padding: 20px;
        text-align: center;
        font-weight: 600;
        border-bottom: 2px solid #0056b3;
        position: relative;
        /* Add relative positioning for button placement */
    }

    .card-body {
        padding: 30px;
    }

    .card-body img {
        width: 100%;
        max-width: 250px;
        height: 250px;
        /* Thay đổi chiều cao để ảnh thành hình vuông */
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid #e9ecef;
    }

    .card-title {
        font-size: 28px;
        margin-bottom: 15px;
        color: #333;
        font-weight: 500;
    }

    .card-text {
        font-size: 18px;
        margin-bottom: 12px;
        color: #555;
    }

    .card-text span {
        font-weight: 600;
        color: #007bff;
    }

    .row {
        display: flex;
        align-items: center;
    }

    .col-md-5 {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-right: 15px;
    }

    .col-md-7 {
        padding-left: 15px;
    }

    .btn-edit {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .btn-edit i {
        font-size: 20px;
        color: #007bff;
    }

    @media (max-width: 768px) {
        .card {
            width: 100%;
            border-radius: 0;
        }

        .row {
            flex-direction: column;
            text-align: center;
        }

        .col-md-5,
        .col-md-7 {
            padding: 0;
        }

        .card-body img {
            max-width: 200px;
            height: 200px;
            /* Điều chỉnh cho phù hợp với kích thước nhỏ hơn */
        }

        .modal {
            display: block !important;
            /* Chỉ để kiểm tra, không nên để trong sản phẩm */
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            border-bottom: 2px solid #0056b3;
        }
    }
</style>

<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            Thông tin người dùng
            <!-- Edit Button as Icon -->
            <button type="button" class="btn-edit" data-toggle="modal" data-target="#editModal">
                <i class="fas fa-edit"></i>
            </button>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    @if($user->userProfile && isset($user->userProfile->image))
                        <img src="data:image;base64,{{ $user->userProfile->image }}" alt="Avatar">
                    @else
                        <p>No image</p>
                    @endif
                </div>

                <div class="col-md-7">
                    <h5 class="card-title">{{ $user->userProfile->name ?? '' }}</h5>
                    <p class="card-text"><span>Email:</span> {{ $user->email }}</p>
                    <p class="card-text"><span>Phone:</span> {{ $user->userProfile->phone ?? '' }}</p>
                    <p class="card-text"><span>Sex:</span> {{ $user->userProfile->sex ?? '' }}</p>
                    <p class="card-text"><span>Role:</span>
                        @if($user->role == 0)
                            User
                        @elseif($user->role == 1)
                            Admin
                        @elseif($user->role == 2)
                            Khách Hàng
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin cá nhân</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Tên:</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->userProfile->name ?? '' }}"
                            required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ $user->userProfile->phone ?? '' }}" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sex">Giới tính:</label>
                        <select name="sex" class="form-control" required>
                            <option value="male" {{ $user->userProfile->sex == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ $user->userProfile->sex == 'female' ? 'selected' : '' }}>Nữ</option>
                        </select>
                        @error('sex')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Cập nhật hình ảnh:</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Font Awesome JS for Edit Icon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

@endsection