<?php

use App\Models\VehicleType;
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

Route::get('/', function () {
    $day = random_int(1, 28);
    $month = random_int(1, 12);

    $hour = random_int(6, 18);
    $minute = random_int(0, 59);
    $second = random_int(0, 59);

    $startAt = \Carbon\Carbon::create(2022, $month, $day, $hour, $minute, $second);
    $finishedAt = $startAt->addMonth();

    echo "now {$startAt} - {$finishedAt}";
});
