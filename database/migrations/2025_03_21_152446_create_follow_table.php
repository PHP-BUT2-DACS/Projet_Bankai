<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follow', function (Blueprint $table) {
            // Clés étrangères
            $table->unsignedBigInteger('follower_id');
            $table->unsignedBigInteger('followed_id');

            // Contraintes (optionnel pour SQLite)
            $table->foreign('follower_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('followed_id')->references('id')->on('users')->cascadeOnDelete();

            // Clé primaire composite
            $table->primary(['follower_id', 'followed_id']);

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow');
    }
};
