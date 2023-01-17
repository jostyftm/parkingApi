<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * 
     */
    protected $types = [
        'automovil',
        // 'bus',
        // 'buseta',
        // 'camión',
        // 'camioneta',
        // 'campero',
        // 'microbus',
        // 'tractocamión',
        'motocicleta',
        // 'motocarro',
        // 'mototriciclo',
        // 'volqueta',
        // 'otro'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->types as $type){
            VehicleType::create([
                'name'  =>  $type,
                'price' =>  1000
            ]);
        }
    }
}
