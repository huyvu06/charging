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
    
        // Sử dụng 'id' thay vì 'user_id' để lọc các trạm sạc
        $stations = TramSac::where('user_id', $user->id)->where('status', 1)->get();
        \Log::info('Stations:', $stations->toArray());
    
        return view('auth.manage_stations', compact('stations'));
    }
    

public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần phải đăng nhập để thực hiện thao tác này.');
    }

    // Xác thực các trường yêu cầu
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string',
        'name_tramsac' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'required|string',
        'loai_tram' => 'required|string',
        'loai_sac' => 'required|string',
        'map' => 'required|string', 
    ]);

    try {
        // Tách tọa độ kinh độ và vĩ độ từ trường 'map'
        $coordinates = explode(',', $request->map);
        $lat = isset($coordinates[0]) ? trim($coordinates[0]) : null;
        $lon = isset($coordinates[1]) ? trim($coordinates[1]) : null;
        $imageName = base64_encode(file_get_contents($request->file('image')->path()));

        $user = Auth::user();

        $station = TramSac::create([
            'name' => $request->input('name'),
            'email' => $user->email, // Sử dụng email của người dùng đang đăng nhập
            'phone' => $request->input('phone'),
            'name_tramsac' => $request->input('name_tramsac'),
            'image' => $imageName,
            'content' => $request->input('content'),
            'map_lat' => $lat, 
            'map_lon' => $lon, 
            'address' => $request->input('address'),
            'loai_tram' => $request->input('loai_tram'),
            'loai_sac' => $request->input('loai_sac'),
            'user_id' => $user->id,
            'id_doitac' => null,
            'confirmation_token' => Str::random(40),
            'status' => 0, 
        ]);

        $recipientEmail = 'vuvanhuy.tdc.3557@gmail.com'; 

        Mail::to($recipientEmail)->send(new RegisterStationConfirmationMail($station));

        return redirect()->route('tramsac')->with('success', 'Đã gửi thông tin đăng ký trạm sạc thành công. Vui lòng kiểm tra email để xác nhận.');
    } catch (\Exception $e) {
        return back()->with('error', 'Có lỗi xảy ra khi đăng ký trạm sạc: ' . $e->getMessage());
    }
}



public function confirm($token)
{
    
    $station = TramSac::where('confirmation_token', $token)->first();
   
    if (!$station) {
        return redirect()->route('home')->with('error', 'Token xác nhận không hợp lệ.');
    }
   
    if ($station->status === 1) {
        return redirect()->route('home')->with('info', 'Trạm sạc đã được xác nhận trước đó.');
    }
   
    $station->status = 1;
    $station->confirmation_token = null;
    $station->save();
   
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
