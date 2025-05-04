<?php
// database/seeders/TeamSeeder.php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::factory(30)->create();
    }
}
