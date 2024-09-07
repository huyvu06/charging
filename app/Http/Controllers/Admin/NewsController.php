<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\news;

class NewsController extends Controller
{
    public function news()
    {
        $news = News::all();
        return view('Admin.news', compact('news'));
    }
}
