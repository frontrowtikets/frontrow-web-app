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
        Schema::create('movie_show_time_seats', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('movie_show_time_id');
            $table->foreign('movie_show_time_id')->references('id')->on('movie_show_times')->onDelete('cascade');
            $table->string('seat_number')->nullable();
            $table->string('row_name')->nullable();
            $table->string('column_name')->nullable();
            $table->string('seat_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_show_time_seats');
    }
};
