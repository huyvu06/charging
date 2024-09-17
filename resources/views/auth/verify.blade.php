
@extends('nav.header')
@section('title', 'xác thực token')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">Xác thực Email</div>
        <div class="card-body">
            <form action="{{ route('verify') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="token">Nhập mã xác thực:</label>
                    <input type="text" id="token" name="token" class="form-control" required>
                    @error('token')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Xác thực</button>
            </form>
        </div>
    </div>
</div>
@endsection
