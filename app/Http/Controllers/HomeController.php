<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tramsac;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function Home(){
        return view('auth.home');
    }
    public function getNew(){
        return view('auth.news');
    }
    public function tramsac(){
        return view('auth.manage_stations');
    }
}
