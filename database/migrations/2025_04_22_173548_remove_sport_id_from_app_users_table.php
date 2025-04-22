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
        Schema::table('app_users', function (Blueprint $table) {
            // Suppression de la clé étrangère et de la colonne
            $table->dropConstrainedForeignId('sport_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_users', function (Blueprint $table) {
            // Recréation de la colonne si on revient en arrière
            $table->foreignId('sport_id')->nullable()->constrained('sports')->onDelete('set null');
        });
    }
};
