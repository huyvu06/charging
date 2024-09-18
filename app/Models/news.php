<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_news';
    protected $table = 'news';
    protected $fillable = ['title', 'image', 'content', 'binhluan'];
}
