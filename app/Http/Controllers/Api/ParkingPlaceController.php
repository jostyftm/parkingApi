<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkingPlaceCreateRequest;
use App\Http\Requests\ParkingPlaceUpdateRequest;
use App\Models\ParkingPlace;
use Illuminate\Http\Request;

class ParkingPlaceController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parkingPlaces = ParkingPlace::all();

        return $this->successResponse($parkingPlaces);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParkingPlaceCreateRequest $request)
    {
        $parkingPlaceSaved = ParkingPlace::create($request->all());

        return $this->successResponse($parkingPlaceSaved);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParkingPlace  $parkingPlace
     * @return \Illuminate\Http\Response
     */
    public function show(ParkingPlace $parkingPlace)
    {
        return $this->successResponse($parkingPlace);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParkingPlace  $parkingPlace
     * @return \Illuminate\Http\Response
     */
    public function update(ParkingPlaceUpdateRequest $request, ParkingPlace $parkingPlace)
    {
        $parkingPlace->fill($request->all());
        $parkingPlace->update();

        return $this->successResponse($parkingPlace);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParkingPlace  $parkingPlace
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParkingPlace $parkingPlace)
    {
        $parkingPlace->delete();

        return $this->successResponse([], 204);
    }
}
