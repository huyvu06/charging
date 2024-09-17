<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
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
        'role' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:255', 
        'address' => 'nullable|string|max:255',
        'sex' => 'nullable|in:male,female',
    ]);

   
    if (User::where('email', $req->email)->exists()) {
        return redirect()->back()
            ->withErrors(['email' => 'Email này đã được sử dụng để đăng ký tài khoản.'])
            ->withInput();
    }

   
    DB::beginTransaction();

    try {
       
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        
        UserProfile::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'] ?? null, 
            'address' => $validatedData['address'] ?? null, 
            'sex' => $validatedData['sex'] ?? null, 
            'user_id' => $user->id,
        ]);

       
        DB::commit();

    } catch (\Throwable $th) {
       
        DB::rollBack();

        dd($th->getMessage(), $th->getTrace());

        return redirect()->back()
            ->withErrors(['error' => 'Đã xảy ra lỗi khi tạo tài khoản và hồ sơ.'])
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
    
    public function showProfile()
{
    $user = Auth::user()->load('userProfile');

    return view('auth.profile', ['user' => $user]);
}


}
