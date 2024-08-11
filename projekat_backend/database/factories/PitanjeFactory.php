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
            'tekst_pitanja' => $this->faker->sentence(),
            'kod_sobe' => '', // Polje kod_sobe će biti popunjeno u SobaSeeder-u
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        return $this->afterCreating(function (Pitanje $pitanje) {
            // Kreiramo 4 odgovora za svako pitanje
            $pitanje->odgovori()->createMany([
                ['tekst_odgovora' => $this->faker->sentence(), 'tacan_odgovor' => true],
                ['tekst_odgovora' => $this->faker->sentence(), 'tacan_odgovor' => false],
                ['tekst_odgovora' => $this->faker->sentence(), 'tacan_odgovor' => false],
                ['tekst_odgovora' => $this->faker->sentence(), 'tacan_odgovor' => false],
            ]);
        });
    }
}

