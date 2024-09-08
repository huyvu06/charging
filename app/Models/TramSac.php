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
        'content',
        'map_lat',             // Thêm trường này
        'map_lon',             // Thêm trường này
        'address',
        'user_id',
        'id_doitac',
        'confirmation_token',
        'status',
    ];

    public $timestamps = true;
}
