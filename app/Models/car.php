<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    use HasFactory;

    protected $table = 'car'; 
    protected $primaryKey = 'id'; 
    protected $fillable = ['id', 'name', 'charging_port_id']; 

    // Relationship to charging port
    public function chargingPort(): BelongsTo
    {
        return $this->belongsTo(ChargingPort::class, 'charging_port_id', 'id_charging_port');
    }
}
