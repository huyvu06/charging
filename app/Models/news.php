<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_news';
    protected $table = 'news';
    protected $fillable = ['title', 'image', 'noidung', 'binhluan','view','date_up','date_edit'];
}
