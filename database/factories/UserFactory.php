<?php

Namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'username' => $this->faker->unique()->userName,
            'favorite_sports' => implode(',', $this->faker->randomElements(['football', 'basket', 'formule1'], rand(1, 3))),
            'follower_list' => null,
            'followed_list' => null,
            'bio' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'avatar' => $this->faker->imageUrl(),
            'active' => 'yes',
            'role' => 'user',
            'remember_token' => Str::random(10),
        ];
    }
}
