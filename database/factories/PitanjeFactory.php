<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pitanje;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pitanje>
 */
class PitanjeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tekst_pitanja' => $this->faker->sentence,   
            'tezina' => $this->faker->numberBetween(1,3),
        ];
    }
}
