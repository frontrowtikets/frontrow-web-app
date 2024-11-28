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
        Schema::create('movie_tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->string('user_email');
            $table->foreignUuid('movie_show_time_id')->references('id')->on('movie_show_times')->onDelete('cascade');
            $table->foreignUuid('movie_show_time_seat_id')->references('id')->on('movie_show_time_seats')->onDelete('cascade');
            $table->decimal('total_price', total: 12);
            $table->timestamp('purchase_date')->nullable();
            $table->date('used_at')->nullable();
            $table->string('ticket_status',100)->nullable();
            $table->string('ticket_url')->nullable();
            $table->string('ticket_id');
            $table->string('booking_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_tickets');
    }
};
