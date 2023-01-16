<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\IdentificationTypeController;
use App\Http\Controllers\Api\ParkingPlaceController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleTypeController;
use App\Http\Controllers\StatisticController;
use App\Models\IdentificationType;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Public routes
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/reservations/{reservation}/getInfoToPay', [ReservationController::class, 'getInfoToPay']);

Route::prefix('statistics')->group(function(){

    Route::get('reservationByState', [StatisticController::class, 'reservationByState']);
    Route::get('reservationByDay', [StatisticController::class, 'reservationByDay']);
    Route::get('registrationclient', [StatisticController::class, 'registrationclient']);
    Route::get('raisedMoney', [StatisticController::class, 'raisedMoney']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('vehicleTypes', VehicleTypeController::class);
    Route::resource('identificationTypes', IdentificationTypeController::class);
    Route::resource('users', UserController::class);
    Route::resource('clients', ClientController::class);
    Route::post('clients/verifyClient', [ClientController::class, 'verifyClient']);
    
    Route::resource('employees', EmployeeController::class);
    Route::resource('parkingPlaces', ParkingPlaceController::class);
    Route::resource('vehicleTypes', VehicleTypeController::class);
    Route::post('reservations/{reservation}/payReservation', [ReservationController::class, 'payReservation']);
    Route::resource('reservations', ReservationController::class);
});