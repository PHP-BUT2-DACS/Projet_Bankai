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
            $table->string('follower_username', 50);
            $table->string('followed_username', 50);
            $table->primary(['follower_username', 'followed_username']);
            $table->foreign('follower_username')->references('username')->on('app_users')->onDelete('cascade');
            $table->foreign('followed_username')->references('username')->on('app_users')->onDelete('cascade');
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
