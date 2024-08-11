<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Soba;
use App\Models\Pitanje;



class SobaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kreiramo 10 soba
        $sobe = Soba::factory(10)->create();

        // Za svaku sobu, kreiramo pitanje sa istim kodom sobe
        $sobe->each(function ($soba) {
            Pitanje::factory(10)->create(['kod_sobe' => $soba->kod_sobe]);
        });
    }
}


