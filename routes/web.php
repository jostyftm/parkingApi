<?php

use App\Http\Controllers\Api\Pdf\ReservationPdfController;
use App\Models\Reservation;
use App\Pdf\TicketIn;
use App\Pdf\TicketReservation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('prints')->group(function(){

    Route::get('{reservation}/reservationIn', [ReservationPdfController::class, 'printTicketReservationIn']);
    Route::get('{reservation}/reservationOut', [ReservationPdfController::class, 'printTicketReservationOut']);
});

Route::get('/', function () {
    $reservation = Reservation::find(3);

    dd($reservation->getTotalToPay());
});
