<?php

Namespace Database\Factories;



namespace Database\Factories;

use App\Models\Sport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company,
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'sport_id' => Sport::inRandomOrder()->first()->id ?? Sport::factory(),
        ];
    }
}
