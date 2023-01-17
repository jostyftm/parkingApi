<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $day = random_int(1, 28);
        $month = random_int(1, 12);

        $hour = random_int(6, 18);
        $minute = random_int(0, 59);
        $second = random_int(0, 59);

        $createdAt = \Carbon\Carbon::now()->subMonths(random_int(1, 3))->subDays(1, 4);
        // $createdAt = \Carbon\Carbon::create(2022, $month, $day, $hour, $minute, $second);

        return [
            'user_id'       =>  User::factory()->create()->id,
            'created_at'    =>  $createdAt
        ];
    }
}