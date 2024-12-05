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
            $table->unsignedBigInteger('event_ticket_id');
            $table->foreign('event_ticket_id')->references('id')->on('event_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_event_tickets', function (Blueprint $table) {
            $table->dropColumn(['event_ticket_id']);
        });
    }
};
