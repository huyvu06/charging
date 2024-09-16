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
    public function login()
    {
        return view('auth.login');
    }
    public function sign()
    {
        return view('auth.sign');
    }

    public function postSign(Request $req)
{
    // Xác thực dữ liệu đầu vào
    $validatedData = $req->validate([
        'name' => 'required',
        'role' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if (User::where('email', $req->email)->exists()) {
        
        return redirect()->back()
            ->withErrors(['email' => 'Email này đã được sử dụng để đăng ký tài khoản.'])
            ->withInput();
    }
    $validatedData['password'] = Hash::make($req->password);

    try {
      
        User::create($validatedData);
    } catch (\Throwable $th) {
        
        return redirect()->back()
            ->withErrors(['error' => 'Đã xảy ra lỗi khi tạo tài khoản.'])
            ->withInput();
    }

    
    return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush(); 
        $request->session()->regenerate(); 

        return redirect()->route('login');
    }

    public function postLogin(Request $req)
    {
        $credentials = $req->only('email', 'password');
        
     
        $remember = $req->has('remember');
    
        if (Auth::attempt($credentials, $remember)) {
          
            session(['user_name' => Auth::user()->name]);
            \Log::info('User logged in:', ['user_id' => Auth::user()->id]);
            return redirect()->route('home');
        }
    
        return redirect()->back()->with('error', 'Thông tin đăng nhập không đúng.');
    }
    
    

}
