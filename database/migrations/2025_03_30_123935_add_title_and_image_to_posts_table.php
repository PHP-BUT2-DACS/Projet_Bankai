<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title', 255)->nullable()->after('user_id'); // Ajoute la colonne title, nullable
            $table->string('image', 255)->nullable()->after('title');   // Ajoute la colonne image, nullable
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title', 'image']);
        });
    }
};
