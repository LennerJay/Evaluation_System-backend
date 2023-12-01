<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' =>fake()->firstName(),
            'middle_name' =>fake()->firstName(),
            'last_name'=>fake()->lastName(),
            'course'=>  fake()->randomElement(['BSIT','BEED','BSHRM']),
            'email' => fake()->unique()->safeEmail(),
            'mobile_number' => fake()->numerify('###########'),
            'regular' => fake()->randomElement([0,1]),
        ];
    }
}
