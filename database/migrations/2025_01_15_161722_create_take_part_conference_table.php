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
        Schema::create('take_part_conference', function (Blueprint $table) {
            $table->string('user_username', 50);
            $table->unsignedBigInteger('conference_id');
            $table->primary(['user_username', 'conference_id']);
            $table->foreign('user_username')->references('username')->on('app_users')->onDelete('cascade');
            $table->foreign('conference_id')->references('id')->on('conference')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('take_part_conference');
    }
};
