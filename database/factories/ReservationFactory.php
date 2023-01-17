<?php

namespace Database\Factories;

use App\Models\ParkingPlace;
use App\Models\ReservationState;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $employees = User::whereHas('employee')->get()->pluck('id');
        $vehicleType = VehicleType::all()->random();
        $parkingAvailable = ParkingPlace::getAvailableParking()->get()->random();
        $state = ReservationState::all()->random();
        
        $day = random_int(1, 28);
        $month = random_int(1, 12);

        $hour = random_int(6, 18);
        $minute = random_int(0, 59);
        $second = random_int(0, 59);

        $startAt = \Carbon\Carbon::create(2022, $month, $day, $hour, $minute, $second);
        $finishedAt = $startAt;

        if($state->id !== 3){
            $addminutes = random_int(10, 2880);
            $finishedAt = \Carbon\Carbon::create(2022, $month, $day, $hour, $minute, $second)->addMinutes($addminutes);
            $state->id = 2;
        }

        return [
            'attended_by'           =>  $employees->random(),
            'vehicle_type_id'       =>  $vehicleType->id,
            'license_plate'         =>  "abc{$this->faker->numberBetween(100, 999)}",
            'parking_place_id'      =>  $parkingAvailable->id,
            'reservation_state_id'  =>  $state->id,
            'started_at'            =>  $startAt,
            'finished_at'           =>  $finishedAt,
            'hour_price'            =>  $vehicleType->price
        ];
    }
}
