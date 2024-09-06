<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function sign(){
        return view('auth.sign');
    }
    
    public function postSign(Request $req)
{
    
    $validatedData = $req->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    // dd($validatedData);
    $validatedData['password'] = Hash::make($req->password);

    // dd($validatedData);
    try {
        User::create($validatedData);

    } catch (\Throwable $th) {
        dd($th); 
    }

    return redirect()->route('login');
}

public function logout(Request $request) {
    Auth::logout();
    $request->session()->flush(); // Xóa toàn bộ dữ liệu session
    $request->session()->regenerate(); // Tạo lại ID session để tránh tấn công session fixation

    return view('auth.home');
}

public function postLogin(Request $req) {
    $credentials = $req->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Lưu thông tin người dùng vào session
        session(['user_name' => Auth::user()->name]);

        return redirect()->route('home');
    }

    return redirect()->back()->with('error', 'Thông tin đăng nhập không đúng.');
}



}
