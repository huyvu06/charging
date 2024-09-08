<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tramsac;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\RegisterStationConfirmationMail;

class TramSacController extends Controller
{

  
    public function store(Request $request)
{
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần phải đăng nhập để thực hiện thao tác này.');
    }

    // Xác thực các trường yêu cầu
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:tram_sac', 
        'name_tramsac' => 'required|string|max:255',
        'address' => 'required|string',
    ]);

    try {
        // Lấy user_id từ người dùng hiện tại
        $user_id = Auth::id();

        // Tạo mới trạm sạc nhưng chưa kích hoạt
        $station = TramSac::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'name_tramsac' => $request->input('name_tramsac'),
            'content' => $request->input('content'),
            'map' => $request->input('map'),
            'address' => $request->input('address'),
            'user_id' => $user_id,
            'id_doitac' => null,
            'confirmation_token' => Str::random(40),
            'is_activated' => false,
        ]);

        $recipientEmail = 'vuvanhuy.tdc.3557@gmail.com'; // Đặt địa chỉ email của người nhận vào đây

            // Gửi email xác nhận đến người nhận
            Mail::to($recipientEmail)->send(new RegisterStationConfirmationMail($station));

        // Chuyển hướng với thông báo thành công
        return redirect()->route('tramsac')->with('success', 'Đã gửi thông tin đăng ký trạm sạc thành công. Vui lòng kiểm tra email để xác nhận.');

    } catch (\Exception $e) {
        // Xử lý lỗi nếu xảy ra
        return back()->with('error', 'Có lỗi xảy ra khi đăng ký trạm sạc: ' . $e->getMessage());
    }
}

public function confirm($token)
{
    // Find the station by the confirmation token
    $station = TramSac::where('confirmation_token', $token)->first();

    if (!$station) {
        return redirect()->route('tramsac')->with('error', 'Token xác nhận không hợp lệ.');
    }

    // Activate the station
    $station->is_activated = true;
    $station->confirmation_token = null; // Optional: clear the token after confirmation
    $station->save();

    return redirect()->route('home')->with('success', 'Trạm sạc đã được kích hoạt thành công.');
}

public function index()
{
    // Lấy user_id từ người dùng hiện tại
    $user_id = Auth::id();

    // Lấy danh sách các trạm sạc của người dùng
    $stations = TramSac::where('user_id', $user_id)->get();

    // Trả về view và truyền dữ liệu
    return view('auth.manage_stations', compact('stations'));
}


}
