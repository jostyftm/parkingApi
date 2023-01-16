<?php

namespace Database\Seeders;

use App\Models\IdentificationType;
use Illuminate\Database\Seeder;

class IdentificationTypeSeeder extends Seeder
{
    /**
     * 
     */
    private $data = [
        [
            'name'      => 'cedula de ciudadania',
            'prefix'    =>  'c.c'
        ],
        [
            'name'      => 'tarjeta de identidad',
            'prefix'    =>  't.i'
        ],
        [
            'name'      => 'cedula extranjeta',
            'prefix'    =>  'c.e'
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->data as $value){
            IdentificationType::create($value);
        } 
    }
}
