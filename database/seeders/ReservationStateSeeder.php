<?php

namespace Database\Seeders;

use App\Models\ReservationState;
use Illuminate\Database\Seeder;

class ReservationStateSeeder extends Seeder
{

    private $states = [
        [
            'name'          =>  'reservado',
            'text_color'   =>  '#FFFFFF',
            'bg_color'     =>  '#3dd5f3',
        ],
        [
            'name'          =>  'terminado',
            'text_color'   =>  '#FFFFFF',
            'bg_color'     =>  '#4dd4ac',
        ],
        [
            'name'          =>  'cancelado',
            'text_color'   =>  '#FFFFFF',
            'bg_color'     =>  '#dc3545',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->states as $state){
            ReservationState::create($state);
        }
    }
}
