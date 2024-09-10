    @extends('Admin.Dashboard')
    @section('title', 'News')
    @section('content')

    <div class="container mt-4">
        <h2>Table News Articles</h2>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add News Button -->
        <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#addNewsModal">
            Thêm Tin Tức
        </button>

        <!-- News Table -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Content</th>
                    <th>Comments</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Image" style="width: 100px; height: auto;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ Str::limit($item->content, 50) }}</td>
                        <td>{{ $item->comments_count }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="#editNewsModal{{ $item->id }}" class="btn btn-primary btn-sm"
                                data-toggle="modal">Sửa</a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.news.delete', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa tin tức này không?')">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit News Modal -->
                    <div class="modal fade" id="editNewsModal{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editNewsModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editNewsModalLabel{{ $item->id }}">Chỉnh sửa tin tức</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.news.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="title">Title:</label>
                                            <input type="text" name="title" class="form-control" value="{{ $item->title }}"
                                                required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="image">Image (Leave empty if not changing):</label>
                                            <input type="file" name="image" class="form-control">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="content">Content:</label>
                                            <textarea name="content" class="form-control" rows="4" required>{{ $item->content }}</textarea>
                                            @error('content')
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

        <!-- Add News Modal -->
        <div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewsModalLabel">Thêm Tin Tức Mới</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" name="image" class="form-control" required>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Content:</label>
                                <textarea name="content" class="form-control" rows="4" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success mt-2">Thêm Tin Tức</button>
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
