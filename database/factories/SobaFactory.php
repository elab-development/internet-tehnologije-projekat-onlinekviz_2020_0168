<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Soba;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Soba>
 */
class SobaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kod_sobe' => $this->faker->unique()->regexify('[A-Za-z0-9]{6}'), 
            'maksimalan_broj_igraca' => $this->faker->numberBetween(5, 10),
            'status' => $this->faker->numberBetween(1,2),
        ];
    }
}
