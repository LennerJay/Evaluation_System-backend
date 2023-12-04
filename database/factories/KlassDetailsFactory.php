<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KlassDetails>
 */
class KlassDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = rand(1,11);
        $endTime = $startTime + 1;


        return [
            'time' => $startTime . ':00 ' .  ' - ' . $endTime . ':00 ' . fake()->randomElement(['am', 'pm']),
            'day'=> fake()->randomElement(['MWF','TTH','Sat'])
        ];
    }
}
