<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'attended_by',
        'vehicle_type_id',
        'license_plate',
        'parking_place_id',
        'reservation_state_id',
        'started_at',
        'finished_at',
        'hour_price',
        'total_paid',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => 'datetime:Y-m-d H:i:s',
        'finished_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * 
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function(Reservation $reservation){

            if(!is_null($reservation->finished_at)){
                $reservation->total_paid = $reservation->getTotalToPay();
                $reservation->update();
            }
        });
    }

    /**
     * 
     */
    public function getTotalPay()
    {
        return number_format($this->total_paid, 2);
    }

    /**
     * 
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * 
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'attended_by');
    }

    /**
     * 
     */
    public function parkingPlace(): BelongsTo
    {
        return $this->belongsTo(ParkingPlace::class, 'parking_place_id');
    }

    /**
     * 
     */
    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    /**
     * 
     */
    public function reservationState(): BelongsTo
    {
        return $this->belongsTo(ReservationState::class, 'reservation_state_id');
    }

    /**
     * 
     */
    public function getTotalToPay()
    {
        $difHour = ceil($this->started_at->floatDiffInHours($this->finished_at));

        return round(($this->hour_price * $difHour), 2);
    }

    /**
     * 
     */
    public function scopeReservationByState(Builder $query, $startAt, $finishedAt)
    {
        $currentQuery = $query->select(DB::raw('COUNT(reservations.id) AS total, reservation_states.name, reservation_states.bg_color, reservation_states.text_color, reservations.reservation_state_id'))
        ->join('reservation_states', 'reservations.reservation_state_id', '=', 'reservation_states.id');

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }

        $currentQuery->groupBy('reservations.reservation_state_id');

        return $currentQuery;
    }

    /**
     * 
     */
    public function scopeReservationByStateAndDay(Builder $query, $startAt, $finishedAt)
    {
        $currentQuery = $query->select(DB::raw('COUNT(reservations.id) AS total, reservation_states.name, DATE(reservations.started_at) AS date, reservations.reservation_state_id'))
        ->join('reservation_states', 'reservations.reservation_state_id', '=', 'reservation_states.id');

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }

        $currentQuery->groupByRaw('date, reservation_states.name, reservations.reservation_state_id')
        ->orderByRaw('date');

        return $currentQuery;
    }

    /**
     * 
     */
    public function scopeReservationByDay(Builder $query, $startAt, $finishedAt)
    {
        $currentQuery = $query->select(DB::raw('COUNT(reservations.id) AS total, DATE(reservations.started_at) AS date'));

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }
        
        $currentQuery->groupByRaw('date');

        return $currentQuery;
    }
   
    /**
     * 
     */
    public function scopeReservationByDayCount(Builder $query, $startAt, $finishedAt)
    {
        $currentQuery = $query->select(DB::raw('COUNT(reservations.id) AS total'));

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }

        return $currentQuery;
    }

    /**
     * 
     */
    public function scopeRaisedMoney(Builder $query, $startAt, $finishedAt)
    {
        $currentQuery = $query->select(DB::raw('SUM(reservations.total_paid) AS total, DATE(reservations.started_at) AS date'));

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }
        
        $currentQuery->groupByRaw('date');

        return $currentQuery;
    }
   
    /**
     * 
     */
    public function scopeRaisedMoneyCount(Builder $query, $startAt, $finishedAt)
    {
        $currentQuery = $query->select(DB::raw('SUM(reservations.total_paid) AS total'));

        if($startAt !== null && $finishedAt !== null){
            $currentQuery->whereBetween('started_at', [$startAt, $finishedAt]);
        }

        return $currentQuery;
    }

    /**
     * 
     */
    public function scopeSearch(Builder $query, $s)
    {
        if($s){
            return $query->where('id', 'LIKE', "%{$s}%")
            ->orWhereHas('client.user', function($q) use($s) {
                $q->where('name', 'LIKE', "%{$s}%")
                ->orWhere('identification_number', 'LIKE', "%{$s}%");
            })
            ->with('client.user');
        }
    }
}