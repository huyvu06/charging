<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
