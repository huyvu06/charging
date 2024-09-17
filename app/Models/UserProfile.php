<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profile';
    protected $primaryKey = 'user_profile_id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'image',
        'sex',
        'user_id',
    ];

    /**
     * Define a one-to-one relationship with the User model.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
