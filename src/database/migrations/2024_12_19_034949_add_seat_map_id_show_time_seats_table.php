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
        Schema::table('movie_show_time_seats', function (Blueprint $table) {
            $table->unsignedBigInteger('seat_map_id')->nullable();
            $table->foreign('seat_map_id')->references('id')->on('seat_maps')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_show_time_seats', function (Blueprint $table) {
            $table->dropColumn(['seat_map_id']);
        });
    }
};
