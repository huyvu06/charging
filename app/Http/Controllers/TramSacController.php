<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TramSacController;
use Illuminate\Http\Request;
use App\Models\Tramsac;
use App\Models\User;
use App\Models\car; 
use App\Models\ChargingPort; 
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

    \Log::info('Current User ID:', ['user_id' => $user->id]);

    // Lấy danh sách các trạm sạc của người dùng
    $stations = TramSac::with('chargingPort') // Change here to chargingPorts
    ->where('user_id', $user->id)
    ->where('status', 1)
    ->get();

// Nhóm các cổng sạc theo cổng sạc
        $groupedChargingPorts = $stations->flatMap(function ($station) {
            return $station->chargingPort->groupBy('cong_sac'); // Make sure 'cong_sac' exists in the ChargingPort model
        });

        return view('auth.manage_stations', compact('stations', 'groupedChargingPorts'));
}

    
    
   
public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần phải đăng nhập để thực hiện thao tác này.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'regex:/^0[0-9]{9,10}$/|numeric',
        'name_tramsac' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'required|string',
        'map' => 'required|string',
        'charging_port_ids' => 'required|array', 
        'charging_port_ids.*' => 'exists:charging_port,id_charging_port',
    ]);

    try {
        $coordinates = explode(',', $request->map);
        $lat = isset($coordinates[0]) ? trim($coordinates[0]) : null;
        $lon = isset($coordinates[1]) ? trim($coordinates[1]) : null;
        $imageName = base64_encode(file_get_contents($request->file('image')->path()));

        $user = Auth::user();

        // Tạo trạm sạc
        $station = TramSac::create([
            'name' => $request->input('name'),
            'email' => $user->email,
            'phone' => $request->input('phone'),
            'name_tramsac' => $request->input('name_tramsac'),
            'image' => $imageName,
            'content' => $request->input('content'),
            'map_lat' => $lat,
            'map_lon' => $lon,
            'address' => $request->input('address'),
            'user_id' => $user->id,
            'id_doitac' => null,
            'confirmation_token' => Str::random(40),
            'status' => 0,
        ]);

        
        $station->chargingPort()->attach($request->input('charging_port_ids'));

        $recipientEmail = 'vuvanhuy.tdc.3557@gmail.com'; 
        Mail::to($recipientEmail)->send(new RegisterStationConfirmationMail($station));

        return redirect()->route('tramsac.index')->with('success', 'Đã gửi thông tin đăng ký trạm sạc thành công. Vui lòng kiểm tra email để xác nhận.');
    } catch (\Exception $e) {
        return back()->with('error', 'Có lỗi xảy ra khi đăng ký trạm sạc: ' . $e->getMessage());
    }
}

    



    public function confirm($token)
    {
        $station = TramSac::where('confirmation_token', $token)->first();
    
        if ($station->status === 1) {
            return response()->json(['info' => 'Trạm sạc đã được xác nhận trước đó.'], 200);
        }
    
        $station->status = 1;
        $station->confirmation_token = null;
        $station->save();
    
        return response()->json(['success' => 'Trạm sạc "' . $station->name . '" đã được xác nhận thành công.']);
    }
    



    public function map()
{
 
    $stations = TramSac::with(['chargingPort', 'chargingPort.cars'])->get(); 

   
    $carTypes = $stations->flatMap(function($station) {
        return $station->chargingPort->flatMap(function($chargingPort) {
            return $chargingPort->cars->pluck('name'); 
        });
    })->unique()->values()->toArray(); 

   
    $chargingPorts = $stations->flatMap(function($station) {
        return $station->chargingPort->pluck('cong_sac'); 
    })->unique()->values()->toArray(); 

    \Log::info('Stations:', $stations->toArray());
    \Log::info('Car Types:', $carTypes);
    \Log::info('Charging Ports:', $chargingPorts); 

    return view('auth.map', compact('stations', 'carTypes', 'chargingPorts'));
}





}
