<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'user_username' => 'leo_messi',
                'title' => 'L’amour du football',
                'text' => 'Le football est un sport qui demande autant de technique que de mental. Qui est votre joueur préféré cette saison ?',
                'post_date' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_username' => 'usain_bolt',
                'title' => 'Secrets de la vitesse',
                'text' => 'La clé pour être un bon sprinter ? L’entraînement, la discipline et une excellente alimentation.',
                'post_date' => now()->subDay()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_username' => 'serena_williams',
                'title' => 'La force mentale au tennis',
                'text' => 'Le tennis, c’est 50% de physique et 50% de mental. Comment gérez-vous la pression en compétition ?',
                'post_date' => now()->subDays(2)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
