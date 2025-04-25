<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Créer une table temporaire avec le nouveau schéma
        Schema::create('app_users_temp', function (Blueprint $table) {
            $table->id(); // Nouvelle clé primaire auto-incrémentée
            $table->string('username', 50)->unique();
            $table->string('mail_address', 100)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('password', 255);
            $table->string('favorite_sports', 255)->nullable();
            $table->text('bio')->nullable();
            $table->string('location', 100)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('banner', 255)->nullable();
            $table->boolean('verified')->default(false);
            $table->string('active', 10)->nullable();
            $table->timestamps();
        });

        // Migrer les données de l'ancienne table vers la nouvelle
        DB::table('app_users_temp')->insert(
            DB::table('users')->get()->map(function ($user) {
                return [
                    'username' => $user->username,
                    'mail_address' => $user->mail_address,
                    'name' => $user->name,
                    'lastname' => $user->lastname,
                    'password' => $user->password,
                    'favorite_sports' => $user->favorite_sports,
                    'active' => $user->active,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            })->toArray()
        );

        // Supprimer l'ancienne table
        Schema::drop('users');

        // Renommer la table temporaire pour remplacer l'ancienne
        Schema::rename('app_users_temp', 'users');
    }

    public function down(): void
    {
        // Créer une table temporaire avec l'ancien schéma
        Schema::create('app_users_temp', function (Blueprint $table) {
            $table->string('username', 50)->primary();
            $table->string('mail_address', 100)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('password', 255);
            $table->string('favorite_sports', 255)->nullable();
            $table->text('follower_list')->nullable();
            $table->text('followed_list')->nullable();
            $table->string('active', 10)->nullable();
        });

        // Migrer les données de la nouvelle table vers l'ancienne
        DB::table('app_users_temp')->insert(
            DB::table('app_users')->get()->map(function ($user) {
                return [
                    'username' => $user->username,
                    'mail_address' => $user->mail_address,
                    'name' => $user->name,
                    'lastname' => $user->lastname,
                    'password' => $user->password,
                    'favorite_sports' => $user->favorite_sports,
                    'active' => $user->active,
                ];
            })->toArray()
        );

        // Supprimer la nouvelle table
        Schema::drop('app_users');

        // Renommer la table temporaire pour restaurer l'ancienne
        Schema::rename('app_users_temp', 'app_users');
    }
};
