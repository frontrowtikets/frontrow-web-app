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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('beneficiary_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('location_name');
            $table->string('gps_location')->nullable();
            $table->string('status',100);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('ticket_price', total: 10);
            $table->string('thumbnail_url')->nullable();
            $table->string('currency',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
