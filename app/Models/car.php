<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    use HasFactory;
    protected $primarykey = 'id_car';
    protected $table = 'car';
    protected $fillable = ['id_car','name_car','cong_sac','id_tramsac'];

}
