<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkSystem extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_doitac';

    protected $table = 'network_system';
    protected $fillable = ['name', 'phone', 'email', 'khuvuc'];
}
