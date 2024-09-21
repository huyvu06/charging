<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tramsac;
use App\Models\User;
use App\Models\car; 
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
        $cars = Car::all(); 
        \Log::info('Cars:', $cars->toArray());
        return view('auth.tramsac', compact('cars'));
    }
}
