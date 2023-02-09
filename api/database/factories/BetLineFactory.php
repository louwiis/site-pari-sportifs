<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BetLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'bet_id' => $this->faker->numberBetween(1, 200),
            'title' => $this->faker->word,
            'odd' => $this->faker->randomFloat(2, 1, 10),
            'status' => $this->faker->randomElement(['pending', 'won', 'lost']),
        ];
    }
}
