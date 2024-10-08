@extends('nav.header')
@section('title', 'Tramsac')
@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .container {
        width: 100%;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f4f4f4;
        padding: 20px;
    }

    .form-container {
        width: 100%;
        max-width: 500px;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background: #ffffff;
        text-align: center;
    }

    .form-container h1 {
        margin-bottom: 30px;
        font-size: 24px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        color: #333;
    }

    .form-group textarea {
        resize: vertical;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    /* Responsive cho màn hình nhỏ */
    @media (max-width: 576px) {
        .form-container {
            padding: 20px;
            max-width: 90%;
        }

        .form-container h1 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group textarea {
            padding: 10px;
            font-size: 14px;
        }

        button {
            padding: 10px;
            font-size: 15px;
        }

        .container {
            padding: 10px;
        }

        .form-group label {
            font-size: 14px;
        }

        .form-container {
            box-shadow: none;
        }
    }

    /* Responsive cho tablet */
    @media (min-width: 577px) and (max-width: 768px) {
        .form-container {
            padding: 25px;
            max-width: 100%;
        }

        .form-container h1 {
            font-size: 22px;
            margin-bottom: 25px;
        }

        .form-group input,
        .form-group textarea {
            padding: 11px;
            font-size: 15px;
        }

        button {
            padding: 11px;
            font-size: 16px;
        }
    }
</style>

<div class="container">
    <form class="form-container" method="POST" action="{{ route('tramsac.store') }}" enctype="multipart/form-data">
        @csrf
        <h1>Đối Tác Chiến Lược</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="name">Họ Và Tên(*):</label>
            <input type="text" id="name" name="name" required value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="phone">Số Điện Thoại(*):</label>
            <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}">
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name_tramsac">Tên Trạm Sạc(*):</label>
            <input type="text" id="name_tramsac" name="name_tramsac" required value="{{ old('name_tramsac') }}">
        </div>
        <div class="form-group">
            <label for="image">Hình ảnh(*):</label>
            <input type="file" id="image" name="image" required accept="image/*">
        </div>
        <div class="form-group">
            <label>Chọn Cổng Sạc(*):</label>
            @if($chargingPorts->isEmpty())
                <p>Chưa có cổng sạc nào trong hệ thống.</p>
            @else
                @foreach($chargingPorts as $chargingPort)
                    <div>
                        <input type="checkbox" id="charging_port_{{ $chargingPort->id_charging_port }}" name="charging_port_ids[]" value="{{ $chargingPort->id_charging_port }}">
                        <label for="charging_port_{{ $chargingPort->id_charging_port }}">{{ $chargingPort->cong_sac }}</label>
                    </div>
                @endforeach
            @endif
        </div>
        
        
        <div class="form-group">
            <label for="content">Nội Dung:</label>
            <input type="text" id="content" name="content" value="{{ old('content') }}">
        </div>
        <div class="form-group">
            <label for="map">Kinh Độ & Vĩ Độ:</label>
            <input type="text" id="map" name="map" placeholder="Nhấp vào 'Lấy Vị Trí' để tự động điền hoặc nhập thủ công" value="{{ old('map') }}">
            <button type="button" id="getLocation" class="btn btn-secondary">Lấy Vị Trí</button>
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <textarea id="address" name="address" rows="4" required>{{ old('address') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('getLocation').addEventListener('click', function () {
            const mapInput = document.getElementById('map');
            const errorContainer = document.createElement('div');
            errorContainer.style.color = 'red';
            errorContainer.style.marginTop = '10px';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const lat = position.coords.latitude.toFixed(6); 
                        const lon = position.coords.longitude.toFixed(6); 
                        mapInput.value = lat + ', ' + lon;
                    },
                    function (error) {
                        let message = '';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                message = 'Bạn đã từ chối yêu cầu lấy vị trí.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                message = 'Vị trí không khả dụng.';
                                break;
                            case error.TIMEOUT:
                                message = 'Yêu cầu lấy vị trí hết thời gian.';
                                break;
                            case error.UNKNOWN_ERROR:
                                message = 'Lỗi không xác định.';
                                break;
                        }
                        mapInput.value = '';
                        if (!document.querySelector('#error-message')) {
                            errorContainer.id = 'error-message';
                            errorContainer.textContent = message;
                            document.querySelector('.form-container').appendChild(errorContainer);
                        } else {
                            errorContainer.textContent = message;
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 15000, 
                        maximumAge: 0 
                    }
                );
            } else {
                mapInput.value = '';
                if (!document.querySelector('#error-message')) {
                    errorContainer.id = 'error-message';
                    errorContainer.textContent = 'Geolocation không được hỗ trợ bởi trình duyệt của bạn.';
                    document.querySelector('.form-container').appendChild(errorContainer);
                } else {
                    errorContainer.textContent = 'Geolocation không được hỗ trợ bởi trình duyệt của bạn.';
                }
            }
        });
    });
</script>
@endsection
