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
        Schema::table('user_event_tickets', function (Blueprint $table) {
            $table->string('user_email');
            $table->index('user_email');
            $table->string('ticket_id')->unique();
            $table->string('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_event_tickets', function (Blueprint $table) {
            $table->dropColumn(['user_email', 'ticket_id', 'booking_id',]);
        });
    }
};
