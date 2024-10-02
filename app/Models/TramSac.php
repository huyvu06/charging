<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 

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
        'user_id',
        'id_doitac',
        'confirmation_token',
        'status',
    ];

    public $timestamps = true;

    /**
     * Define a belongs-to relationship with the User model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Define a belongs-to-many relationship with the ChargingPort model.
     *
     * @return BelongsToMany
     */
    public function chargingPorts(): BelongsToMany
    {
        return $this->belongsToMany(ChargingPort::class, 'tram_sac_car', 'tram_sac_id', 'charging_port_id');
    }
}

