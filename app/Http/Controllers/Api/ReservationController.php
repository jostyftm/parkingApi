<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationCreateRequest;
use App\Models\Employee;
use App\Models\ParkingPlace;
use App\Models\Reservation;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::with('client.user')
        ->with('vehicleType', 'reservationState')
        ->get();

        return $this->successResponse($reservations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationCreateRequest $request)
    {
        
        $vehicleType = VehicleType::find($request->vehicle_type_id);
        
        
        $placeAvaliable = ParkingPlace::getAvailableParking()->get();

        if(count($placeAvaliable) == 0){
            return $this->errorResponse([
                'license_plate' =>  'No hay cupos disponibles'
            ], 'Error de validaciòn' ,422); 
        }

        $placeAvaliable = $placeAvaliable->random();
        
        $employee = Employee::where('user_id', '=', $request->user()->id)->first();
        
        $reservationCreated = new Reservation([
            'client_id'         =>  $request->client_id,
            'attended_by'       =>  $employee->id,
            'vehicle_type_id'   =>  $request->vehicle_type_id,
            'hour_price'        =>  $vehicleType->price,
            'license_plate'     =>  $request->license_plate,
            'parking_place_id'  =>  $placeAvaliable->id,
            'started_at'        =>  Carbon::now(),
        ]);
        
        DB::transaction(function() use ($reservationCreated, $placeAvaliable){
        
            $reservationCreated->save();
    
            $placeAvaliable->update(['is_avaliable' => false]);

            return $this->successResponse($reservationCreated);
        });
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $reservation->client->user;
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function getInfoToPay(Request $request, Reservation $reservation)
    {
        dd($reservation->getTotalToPay());
    }

    public function payReservation(Request $request, Reservation $reservation)
    {
        
        DB::transaction(function() use ($reservation){
        
            $now = \Carbon\Carbon::now();

            $reservation->update([
                'reservation_state_id'  =>  2,
                'total_paid'            =>  $reservation->getTotalToPay(),
                'finished_at'           =>  $now
            ]);

            $reservation->parkingPlace()->update([
                'is_avaliable'  =>  true
            ]);
        });
        
        return $this->successResponse($reservation);
    }
}
