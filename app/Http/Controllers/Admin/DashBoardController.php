<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function logout(){
        
        return view('auth.login');
    }
}
