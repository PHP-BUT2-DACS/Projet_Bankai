<?php

// database/factories/PostFactory.php

namespace Database\Factories;

use App\Models\User;
use App\Models\Sport;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'sports', true, 'post'),
            'sport_id' => Sport::inRandomOrder()->first()->id ?? Sport::factory(),
        ];
    }
}
