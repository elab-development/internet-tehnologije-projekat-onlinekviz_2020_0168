<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Petar',
            'email' => 'admin@example.com',
            'password' =>'petarpetrovic01',
            'role' => 'admin',
        ]);
    }
}

