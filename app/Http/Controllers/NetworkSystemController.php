<?php

namespace App\Http\Controllers;
use App\Models\NetworkSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NetworkSystemController extends Controller
{
    public function store(Request $request)
    {
        
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'region' => 'required|in:north,central,south',
        ]);

        // Map the region values to your database values
        $regionMap = [
            'north' => 'bắc',
            'central' => 'trung',
            'south' => 'nam',
        ];

        // Create a new NetworkSystem record
        NetworkSystem::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'khuvuc' => $regionMap[$request->region],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Đăng ký thành công!');
    }
}
