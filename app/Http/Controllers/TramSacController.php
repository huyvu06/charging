<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TramSacController;
use Illuminate\Http\Request;
use App\Models\Tramsac;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\RegisterStationConfirmationMail;

class TramSacController extends Controller
{
    public function index()
{
    $user = Auth::user();
    if (!$user) {
        \Log::error('User not logged in');
        return redirect()->route('login')->with('error', 'Bạn cần phải đăng nhập để xem trạm sạc.');
    }

    // Debugging: Check if user_id is correct
    \Log::info('Current User ID:', ['user_id' => $user->id]);

    $stations = TramSac::where('user_id', $user->user_id)->where('status', 1)->get();
    \Log::info('Stations:', $stations->toArray());

    return view('auth.manage_stations', compact('stations'));
}

public function store(Request $request)
{
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần phải đăng nhập để thực hiện thao tác này.');
    }

    // Xác thực các trường yêu cầu
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string',
        'email' => 'required|string|email|unique:tram_sac',
        'name_tramsac' => 'required|string|max:255',
        'address' => 'required|string',
        'map' => 'required|string', // Đảm bảo map (tọa độ) không rỗng
    ]);

    try {
        // Tách tọa độ kinh độ và vĩ độ từ trường 'map'
        $coordinates = explode(',', $request->map);
        $lat = isset($coordinates[0]) ? trim($coordinates[0]) : null;
        $lon = isset($coordinates[1]) ? trim($coordinates[1]) : null;

        // Lấy user_id từ người dùng hiện tại
        $user_id = Auth::id();

        // Tạo mới trạm sạc nhưng chưa kích hoạt
        $station = TramSac::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'name_tramsac' => $request->input('name_tramsac'),
            'content' => $request->input('content'),
            'map_lat' => $lat,  // Lưu vĩ độ
            'map_lon' => $lon,  // Lưu kinh độ
            'address' => $request->input('address'),
            'user_id' => $user_id,
            'id_doitac' => null,
            'confirmation_token' => Str::random(40),
            'status' => 0, // Mặc định là chưa xác nhận
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
    // Tìm trạm sạc dựa trên token
    $station = TramSac::where('confirmation_token', $token)->first();

    // Nếu không tìm thấy trạm sạc hoặc token không hợp lệ
    if (!$station) {
        return redirect()->route('home')->with('error', 'Token xác nhận không hợp lệ.');
    }

    // Kiểm tra nếu trạm đã được xác nhận trước đó
    if ($station->status === 1) {
        return redirect()->route('home')->with('info', 'Trạm sạc đã được xác nhận trước đó.');
    }

    // Xác nhận trạm sạc và xóa token
    $station->status = 1;
    $station->confirmation_token = null;
    $station->save();

    // Chuyển hướng đến trang quản lý trạm sạc với thông báo thành công
    return redirect()->route('tramsac.index')->with('success', 'Trạm sạc "' . $station->name . '" đã được xác nhận thành công.');
}

public function map()
{
    // Fetch all stations with their coordinates
    $stations = TramSac::all();

    // Log the stations data for debugging
    \Log::info('Stations:', $stations->toArray());

    return view('auth.map', compact('stations'));
}

}
