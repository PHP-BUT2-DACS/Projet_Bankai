<?php

Namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppUserTeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? 1,
            'team_id' => \App\Models\Team::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
