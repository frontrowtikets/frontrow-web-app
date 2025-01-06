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
        Schema::table('movie_tickets', function (Blueprint $table) {
            $table->unique('ticket_id');
            $table->unique('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_tickets', function (Blueprint $table) {
            $table->dropUnique(['ticket_id']);
            $table->dropUnique(['booking_id']);
        });
    }
};
