<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportSeeder extends Seeder
{
    public function run(): void
    {
        $sports = [
            'Football', 'Basketball', 'Tennis', 'Volleyball', 'Rugby',
            'Natation', 'Cyclisme', 'Athlétisme', 'Golf', 'Boxe'
        ];

        foreach ($sports as $sport) {
            \App\Models\Sport::create(['name' => $sport]);
        }
    }
}
