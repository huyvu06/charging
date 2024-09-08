<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramSac extends Model
{
    use HasFactory;

    protected $table = 'tram_sac';
    protected $primaryKey = 'id_tramsac';
    
    protected $fillable = [
        'name',
        'phone',
        'email',
        'name_tramsac',
        'image',
        'content',
        'map_lat',            
        'map_lon',            
        'address',
        'loai_tram',
        'loai_sac',
        'user_id',
        'id_doitac',
        'confirmation_token',
        'status',
    ];

    public $timestamps = true;
}
