<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('app_users')->insert([
            [
                'username' => 'leo_messi',
                'mail_address' => 'messi@example.com',
                'name' => 'Lionel',
                'lastname' => 'Messi',
                'password' => Hash::make('password123'),
                'favorite_sports' => 'Football',
                'follower_list' => null,
                'followed_list' => null,
                'active' => 'yes',
            ],
            [
                'username' => 'usain_bolt',
                'mail_address' => 'bolt@example.com',
                'name' => 'Usain',
                'lastname' => 'Bolt',
                'password' => Hash::make('password123'),
                'favorite_sports' => 'Athlétisme',
                'follower_list' => null,
                'followed_list' => null,
                'active' => 'yes',
            ],
            [
                'username' => 'serena_williams',
                'mail_address' => 'serena@example.com',
                'name' => 'Serena',
                'lastname' => 'Williams',
                'password' => Hash::make('password123'),
                'favorite_sports' => 'Tennis',
                'follower_list' => null,
                'followed_list' => null,
                'active' => 'yes',
            ],
        ]);
    }
}
