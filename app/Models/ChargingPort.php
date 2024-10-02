<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ChargingPort extends Model
{
    use HasFactory;
    
    protected $table = 'charging_port';
    protected $primaryKey = 'id_charging_port';
    protected $fillable = ['id_charging_port','cong_sac'];
    
    public function tramSacs()
    {
        return $this->belongsToMany(TramSac::class, 'tram_sac_car', 'charging_port_id', 'tram_sac_id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'charging_port_id', 'id_charging_port');
    }
}