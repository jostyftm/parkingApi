<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;

class StatisticController extends ApiController
{
    //

    /**
     * 
     */
    public function reservationByState(Request $request)
    {
        $reservationByState = Reservation::reservationByState(null, null)->get();
        $reservationByDay = Reservation::reservationByStateAndDay(null, null)->get();

        return $this->successResponse([
            'total'     =>  $reservationByState,
            'resume'    =>  $reservationByDay
        ]);
    }

    /**
     * 
     */
    public function reservationByDay(Request $request)
    {
        $reservationByDayCount = Reservation::reservationByDayCount(null, null)->get();
        $reservationByDay = Reservation::reservationByDay(null, null)->get();

        return $this->successResponse([
            'total'     =>  $reservationByDayCount,
            'resume'    =>  $reservationByDay
        ]); 
    }

    /**
     * 
     */
    public function registrationclient(Request $request)
    {   
        $registrationclientCount = Client::RegistrationclientCount(null, null)->get();
        $registrationclient = Client::Registrationclient(null, null)->get();

        return $this->successResponse([
            'total'     =>  $registrationclientCount,
            'resume'    =>  $registrationclient
        ]); 
    }

    /**
     * 
     */
    public function raisedMoney(Request $request)
    {
        $raisedMoneytCount = Reservation::raisedMoneyCount(null, null)->first();
        $raisedMoney = Reservation::raisedMoney(null, null)->get();

        return $this->successResponse([
            'total'     =>  $raisedMoneytCount,
            'resume'    =>  $raisedMoney
        ]); 
    }

}
