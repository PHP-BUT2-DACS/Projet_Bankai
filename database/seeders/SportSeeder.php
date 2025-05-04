<?php

namespace Database\Seeders;
use App\Models\Sport;
use Illuminate\Database\Seeder;


class SportSeeder extends Seeder
{
    public function run(): void
    {
        $sports = [
            'Football', 'Basketball', 'Formule 1'
        ];

        foreach ($sports as $sport) {
            Sport::create(['name' => $sport]);
        }
    }
}
