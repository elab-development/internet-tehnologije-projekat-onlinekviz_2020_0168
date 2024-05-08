<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pitanje;
use App\Models\Soba;


class PitanjeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dobijanje koda sobe
        $kod_sobe = Soba::first()->kod_sobe; // Pretpostavka je da imate bar jednu sobu u bazi

        // Kreiranje 10 pitanja sa istim kodom sobe
        for ($i = 0; $i < 10; $i++) {
            Pitanje::factory()->create([
                'kod_sobe' => $kod_sobe,
            ]);
        }
    }
}

