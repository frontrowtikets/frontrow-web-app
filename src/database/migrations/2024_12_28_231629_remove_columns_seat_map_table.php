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
        Schema::table('seat_maps', function (Blueprint $table) {
            $table->dropIndex(['from']);
            $table->dropIndex(['to']);
            $table->dropIndex(['seats_per_row']);
            $table->dropColumn(['from', 'to', 'seats_per_row']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seat_maps', function (Blueprint $table) {
            $table->string('from', 100)->index()->nullable();
            $table->string('to', 100)->index()->nullable();
            $table->integer('seats_per_row')->index()->nullable();
        });
    }
};
