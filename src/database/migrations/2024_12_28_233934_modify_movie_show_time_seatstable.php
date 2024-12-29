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
            $table->dropColumn(['column_name',]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_show_time_seats', function (Blueprint $table) {
            $table->string('column_name')->nullable();
        });
    }
};
