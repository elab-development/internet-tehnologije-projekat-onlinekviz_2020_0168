<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Odgovor;
use App\Models\Pitanje;
use App\Models\Soba;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(AdminSeeder::class);
        $this->call(SobaSeeder::class);
        $this->call(PitanjeSeeder::class);
        $this->call(OdgovorSeeder::class);
        
    }
}
