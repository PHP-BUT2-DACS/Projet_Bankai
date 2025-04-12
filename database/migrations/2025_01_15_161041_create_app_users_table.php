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
        Schema::create('app_users', function (Blueprint $table) {
            $table->string('username', 50)->primary();
            $table->string('mail_address', 100)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('password', 255);
            $table->foreignId('sport_id')->nullable()->constrained('sports');
            $table->text('follower_list')->nullable();
            $table->text('followed_list')->nullable();
            $table->string('active', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_users');
    }
};
