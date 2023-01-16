<?php

namespace Database\Seeders;

use App\Models\FormalityServiceType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seeds attribute
     *
     *  @var array 
     */
    private $seeds = [
        'migrate',
        'identifictionType',
        'vehicleTypes',
        'rolesAndPermissions',
        'reservationState',
        'parkingPalces',
        'users'
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeds as $seed) {
            $this->command->line("Processing {$seed}");
            call_user_func([$this, $seed]);
        }
    }

    /**
     * Refresh databases
     */
    public function migrate()
    {
        $this->command->call('migrate:refresh');
        $this->command->line('Migrated tables.');
    }

    /**
     * Seed IdentificationType table
     */
    private function identifictionType()
    {
        $this->call(IdentificationTypeSeeder::class);
    }

    /**
     * Seed VehicleTypes Table
     */
    public function vehicleTypes()
    {
        $this->call(VehicleTypeSeeder::class);
    }
       
    /**
     * Seed Rol and Permissions Table
     */
    public function rolesAndPermissions()
    {
        $this->call(RoleSeeder::class);
    }

    /**
     * Seed VehicleBrandSeeder Table
     */
    public function users()
    {
        $this->call(UserSeeder::class);
    }

    /**
     * Seed ReservationStateSeeder Table
     */
    public function reservationState()
    {
        $this->call(ReservationStateSeeder::class);
    }

    /**
     * Seed ParkingPlaceSeeder Table
     */
    public function parkingPalces()
    {
        $this->call(ParkingPlaceSeeder::class);
    }
}
