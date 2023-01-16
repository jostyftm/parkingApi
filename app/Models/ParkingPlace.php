<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'is_avaliable'
    ];

    /**
     * 
     */
    public function scopeGetAvailableParking(Builder $query)
    {
        return $query->where('is_avaliable', '=', true);
    }
}
