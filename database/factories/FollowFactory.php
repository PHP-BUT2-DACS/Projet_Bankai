<?php

Namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FollowFactory extends Factory
{
    public function definition(): array
    {
        $user1 = \App\Models\User::inRandomOrder()->first();
        $user2 = \App\Models\User::where('id', '!=', $user1->id)->inRandomOrder()->first();
        return [
            'follower_id' => $user1->id,
            'followed_id' => $user2->id,
        ];
    }
}
