@extends('nav.header')
@section('title', 'Thông tin cá nhân')
@section('content')

<div class="container">
    <div class="card mt-5">
        <div class="card-header">Thông tin người dùng</div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    @if($user->userProfile && isset($user->userProfile->image))
                        <img src="data:image;base64,{{ $user->userProfile->image }}" alt="Avatar" style="width:300px;height:300px;">
                    @else
                        <p>No image</p>
                    @endif
                </div>

                <div class="col-md-7">
                    <h5 class="card-title">{{ $user->userProfile->name ?? '' }}</h5>
                    <p class="card-text">Email: {{ $user->email }}</p>
                    <p class="card-text">Phone: {{ $user->userProfile->phone ?? '' }}</p>
                    <p class="card-text">Address: {{ $user->userProfile->address ?? '' }}</p>
                    <p class="card-text">Sex: {{ $user->userProfile->sex ?? '' }}</p>
                    <p class="card-text">Role: {{ $user->role }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
