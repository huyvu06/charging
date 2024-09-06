<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller
{
    public function logon(){
        return view('admin.logon');
    }
   // Controller xử lý đăng nhập
   public function postLogon(Request $request)
   {
       \Log::info('Login attempt for email: ' . $request->email);
   
       $credentials = $request->only('email', 'password');
   
       if (Auth::attempt($credentials)) {
           $user = Auth::user();
           \Log::info('Login successful, user ID: ' . $user->user_id . ', role: ' . $user->role);
   
           if ($user->role == 1) {
               \Log::info('Redirecting to admin.index');
               return view('admin.dashboard');
           } else {
               Auth::logout();
               \Log::info('User is not admin, logging out.');
               return redirect()->route('logon')->with('err', 'Access denied.');
           }
       }
   
       \Log::info('Login failed for email: ' . $request->email);
       return redirect()->back()->with('err', 'Sai thông tin');
   }
   
}
