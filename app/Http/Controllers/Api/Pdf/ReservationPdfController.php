<?php

namespace App\Http\Controllers\Api\Pdf;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Pdf\TicketIn;
use App\Pdf\TicketReservation;
use Illuminate\Http\Request;

class ReservationPdfController extends ApiController
{
    /**
     * 
     */
    public function printTicketReservationIn(Request $request, Reservation $reservation)
    {
        
        $user = User::find($request->printedBy);
    
        $pdf = new TicketIn($reservation, $user);

        $pdf->Output("I", "ticket{$reservation->id}.pdf");
        exit();
    }

    /**
     * 
     */
    public function printTicketReservationOut(Request $request, Reservation $reservation)
    {

        $user = User::find($request->printedBy);

        $pdf = new TicketReservation($reservation, $user);
        
        $pdf->Output("I", "ticket{$reservation->id}.pdf");
    }
}
