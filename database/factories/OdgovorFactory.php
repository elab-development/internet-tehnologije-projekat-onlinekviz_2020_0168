<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Odgovor;
use App\Models\Pitanje;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Odgovor>
 */
class OdgovorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pitanje_id' => Pitanje::factory(),
            'tekst_odgovora' => $this->faker->sentence,
            'tacan_odgovor' => $this->faker->boolean,
        ];
    }
}
