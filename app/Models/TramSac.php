<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramSac extends Model
{
    use HasFactory;
    protected $table = 'tram_sac';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'name_tramsac',
        'content',
        'map',
        'address',
        'user_id',
        'id_doitac',
    ];
}
