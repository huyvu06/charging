@extends('Admin.Dashboard')

@section('title', 'Quản Lý Tin Tức')

@section('content')
<div class="container mt-4">
    <h2>Danh Sách Tin Tức</h2>
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

    <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#addNewsModal">
        Thêm Tin Tức
    </button>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Hình Ảnh</th>
                <th>Nội Dung</th>
                <th>Ngày Đăng</th>
                <th>Lượt Xem</th>
                <th>Tổng Số Bình Luận</th>
                <th>Tùy Chọn</th>
            </tr>
        </thead>

        <tbody>
            @foreach($news as $item)
                        <tr>
                            <td>{{ $item->id_news }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                @php
                                    $images = json_decode($item->image);
                                @endphp
                                @if(is_array($images))
                                    @foreach($images as $img)
                                        <img src="{{ asset('storage/' . $img) }}" alt="image" style="width: 100px; margin-right: 5px;">
                                    @endforeach
                                @else
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="image" style="width: 100px;">
                                @endif
                            </td>
                            <td>{{ Str::limit($item->noidung, 200) }}</td>
                            <td>{{ $item->date_up }}</td>
                            <td>{{ $item->view }}</td>
                            <td>{{ $item->binhluan }}</td>
                            <td>
                                <a href="#editNewsModal{{ $item->id_news }}" class="btn btn-primary btn-sm"
                                    data-toggle="modal">Sửa</a>
                                <form action="{{ route('admin.deleteNews', $item->id_news) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa bài viết này không?')">Xóa</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal sửa tin tức -->
                        <div class="modal fade" id="editNewsModal{{ $item->id_news }}" tabindex="-1" role="dialog"
                            aria-labelledby="editNewsModalLabel{{ $item->id_news }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editNewsModalLabel{{ $item->id_news }}">Chỉnh sửa bài viết</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.updateNews', $item->id_news) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="title">Tiêu Đề:</label>
                                                <input type="text" name="title" class="form-control" value="{{ $item->title }}"
                                                    required>
                                                @error('title')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="images">Hình Ảnh:</label>
                                                <input type="file" name="images[]" class="form-control" multiple>
                                            </div>

                                            <div class="form-group">
                                                <label for="noidung">Nội Dung:</label>
                                                <textarea name="noidung" class="form-control"
                                                    required>{{ $item->noidung }}</textarea>
                                                @error('noidung')
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

    <!-- Modal thêm tin tức -->
    <div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewsModalLabel">Thêm Bài Viết Mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addNews') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tiêu Đề:</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="images">Hình Ảnh:</label>
                            <input type="file" name="images[]" class="form-control" multiple required>
                            @error('images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="noidung">Nội Dung:</label>
                            <textarea name="noidung" class="form-control" required>{{ old('noidung') }}</textarea>
                            @error('noidung')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Thêm Bài Viết</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection