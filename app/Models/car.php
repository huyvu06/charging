<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    use HasFactory;
    
    protected $table = 'car';
    protected $primaryKey = 'id_car';
    protected $fillable = ['id_car','name_car','dong_dien','cong_sac'];
    
    public function tramSacs()
    {
        return $this->belongsToMany(TramSac::class, 'tram_sac_car', 'car_id', 'tram_sac_id');
    }
}
