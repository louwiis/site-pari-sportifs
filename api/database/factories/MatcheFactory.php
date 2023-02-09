<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MatcheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'league_id' => $this->faker->numberBetween(1, 10),
            'start_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'home_team' => $this->faker->country,
            'away_team' => $this->faker->country,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
