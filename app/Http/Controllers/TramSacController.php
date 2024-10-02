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

  
    $stations = TramSac::with('chargingPorts')
        ->where('user_id', $user->id)
        ->where('status', 1)
        ->paginate(1);  // Phân trang với 10 mục mỗi trang

    // Nhóm các cổng sạc theo cổng sạc
    $groupedChargingPorts = $stations->flatMap(function ($station) {
        return $station->chargingPorts->groupBy('cong_sac');
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

        
        $station->chargingPorts()->attach($request->input('charging_port_ids'));

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
    // Eager load charging ports and cars associated with charging ports
    $stations = TramSac::with(['chargingPorts', 'chargingPorts.cars'])->get(); 

    // Extract unique car types from the cars associated with the charging ports
    $carTypes = $stations->flatMap(function($station) {
        return $station->chargingPorts->flatMap(function($chargingPort) {
            return $chargingPort->cars->pluck('name'); 
        });
    })->unique()->values()->toArray(); 

    // Extract unique charging port names
    $chargingPorts = $stations->flatMap(function($station) {
        return $station->chargingPorts->pluck('cong_sac'); // Assuming 'cong_sac' is the name of the port
    })->unique()->values()->toArray(); 

    \Log::info('Stations:', $stations->toArray());
    \Log::info('Car Types:', $carTypes);
    \Log::info('Charging Ports:', $chargingPorts); // Log charging ports for debugging

    return view('auth.map', compact('stations', 'carTypes', 'chargingPorts'));
}





}
