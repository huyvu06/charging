@component('mail::message')
# Xác nhận đăng ký trạm sạc

Xin chào,

Cảm ơn bạn đã đăng ký trạm sạc {{ $station->name }}. Vui lòng bấm vào nút dưới đây để xác nhận đăng ký.

@component('mail::button', ['url' => route('tramsac.confirm', ['token' => $station->confirmation_token])])
Chấp nhận đăng ký
@endcomponent

Nếu bạn không đăng ký trạm này, vui lòng bỏ qua email này.

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
