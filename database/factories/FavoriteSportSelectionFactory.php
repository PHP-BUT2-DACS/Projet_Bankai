<?php

Namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteSportSelectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? 1,
            'sport_id' => rand(1, 3),
        ];
    }
}
