<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    /**
     * 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    /**
     * 
     */
    public function scopeRegistrationclientCount(Builder $query, $startAt = null, $finishedAt = null)
    {
        $currentQuery = $query->select(DB::raw('COUNT(clients.id) AS total'));   

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }

        return $currentQuery;
    }

    /**
     * 
     */
    public function scopeRegistrationclient(Builder $query, $startAt = null, $finishedAt = null)
    {
        $currentQuery = $query->select(DB::raw('COUNT(clients.id) AS total, DATE(clients.created_at) AS date'));   

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }

        $currentQuery->groupByRaw('date')
        ->orderByRaw('date');

        return $currentQuery;
    }

    /**
     * Scope search
     * 
     * @param String $s
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, $s)
    {
        if($s){
            return $query->whereHas('user', function($q) use ($s){
                $q->where('name', 'LIKE', "%{$s}%")
                ->orWhere('identification_number', 'LIKE', "%{$s}%");
            });
        }
    }
}
