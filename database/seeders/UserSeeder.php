<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        // Meilleurs joueurs de football
        $footballPlayers = [
            [
                'name' => 'Lionel',
                'lastname' => 'Messi',
                'username' => 'leomessi',
                'email' => 'messi@example.com',
                'favorite_sports' => 'football',
                'bio' => '7 fois Ballon d\'Or, légende du FC Barcelone et du PSG',
                'avatar' => 'https://example.com/messi.jpg'
            ],
            [
                'name' => 'Cristiano',
                'lastname' => 'Ronaldo',
                'username' => 'cristiano',
                'email' => 'ronaldo@example.com',
                'favorite_sports' => 'football',
                'bio' => '5 fois Ballon d\'Or, légende de Manchester United, Real Madrid et Juventus',
                'avatar' => 'https://example.com/ronaldo.jpg'
            ],
            [
                'name' => 'Kylian',
                'lastname' => 'Mbappé',
                'username' => 'k.mbappe',
                'email' => 'mbappe@example.com',
                'favorite_sports' => 'football',
                'bio' => 'Jeune prodige français, star du PSG et de l\'équipe de France',
                'avatar' => 'https://example.com/mbappe.jpg'
            ]
        ];

        // Meilleurs joueurs de basket
        $basketballPlayers = [
            [
                'name' => 'LeBron',
                'lastname' => 'James',
                'username' => 'kingjames',
                'email' => 'lebron@example.com',
                'favorite_sports' => 'basket',
                'bio' => '4 fois MVP NBA, légende des Cavaliers, Heat et Lakers',
                'avatar' => 'https://example.com/lebron.jpg'
            ],
            [
                'name' => 'Michael',
                'lastname' => 'Jordan',
                'username' => 'mj23',
                'email' => 'jordan@example.com',
                'favorite_sports' => 'basket',
                'bio' => '6 fois champion NBA, considéré comme le meilleur joueur de tous les temps',
                'avatar' => 'https://example.com/jordan.jpg'
            ],
            [
                'name' => 'Stephen',
                'lastname' => 'Curry',
                'username' => 'stephcurry',
                'email' => 'curry@example.com',
                'favorite_sports' => 'basket',
                'bio' => 'Meilleur shooteur 3-points de l\'histoire, leader des Warriors',
                'avatar' => 'https://example.com/curry.jpg'
            ]
        ];

        // Meilleurs pilotes de F1
        $f1Drivers = [
            [
                'name' => 'Lewis',
                'lastname' => 'Hamilton',
                'username' => 'lewishamilton',
                'email' => 'hamilton@example.com',
                'favorite_sports' => 'formule1',
                'bio' => '7 fois champion du monde de F1, pilote Mercedes',
                'avatar' => 'https://example.com/hamilton.jpg'
            ],
            [
                'name' => 'Max',
                'lastname' => 'Verstappen',
                'username' => 'maxverstappen',
                'email' => 'verstappen@example.com',
                'favorite_sports' => 'formule1',
                'bio' => 'Champion du monde 2021 et 2022, pilote Red Bull',
                'avatar' => 'https://example.com/verstappen.jpg'
            ],
            [
                'name' => 'Charles',
                'lastname' => 'Leclerc',
                'username' => 'charlesleclerc',
                'email' => 'leclerc@example.com',
                'favorite_sports' => 'formule1',
                'bio' => 'Pilote Ferrari, espoir du championnat du monde',
                'avatar' => 'https://example.com/leclerc.jpg'
            ]
        ];

        // Création des utilisateurs
        foreach (array_merge($footballPlayers, $basketballPlayers, $f1Drivers) as $athlete) {
            User::factory()->create([
                'name' => $athlete['name'],
                'lastname' => $athlete['lastname'],
                'username' => $athlete['username'],
                'email' => $athlete['email'],
                'favorite_sports' => $athlete['favorite_sports'],
                'bio' => $athlete['bio'],
                'avatar' => $athlete['avatar'],
                'role' => 'athlete' // J'ai ajouté un rôle spécial pour les athlètes
            ]);
        }

        // Optionally create an admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'lastname' => 'Root',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'favorite_sports' => 'football,basket',
            'bio' => 'Administrator of the platform.',
            'location' => 'Paris',
            'avatar' => asset('images/profile.png'),
            'active' => 'yes',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}

