<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(50)->create();

        // Optionally create an admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'lastname' => 'Root',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'favorite_sports' => 'football,basket',
            'bio' => 'Administrator of the platform.',
            'location' => 'Paris',
            'avatar' => 'https://example.com/avatar/admin.jpg',
            'active' => 'yes',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
