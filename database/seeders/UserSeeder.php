<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();

        $this->createClient();
    }

    /**
     * 
     */
    private function createAdmin()
    {
        $admin = User::factory()->create([
            'name'                      =>  'Admin',
            'last_name'                 =>  '.',
            'identification_type_id'    =>  1,
            'identification_number'     =>  '11111',
            'email'                     =>  'admin@gmail.com',
            'password'                  =>  bcrypt('123456')
        ]);

        $admin->employee()->save(new Employee([]));

        $admin->assignRole('admin');
    }

    /**
     * 
     */
    private function createClient()
    {
        $clients = Client::factory()->count(15)->create()
        ->each(function(Client $client){
            $client->reservations()->saveMany(Reservation::factory(['client_id' =>  $client->id])->count(10)->create());
        });
    }
}
