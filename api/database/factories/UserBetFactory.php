<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserBet>
 */
class UserBetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 1000),
            'bet_id' => $this->faker->numberBetween(1, 1000),
            'bet_line_id' => $this->faker->numberBetween(1, 1000),
            'odd' => $this->faker->randomFloat(2, 1, 10),
            'status' => $this->faker->randomElement(['pending', 'won', 'lost']),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
