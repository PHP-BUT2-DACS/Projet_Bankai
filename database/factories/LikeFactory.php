<?php

Namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? 1,
            'post_id' => \App\Models\Post::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
