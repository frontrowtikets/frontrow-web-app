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
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_tracking_id')->unique();
            $table->string('order_type'); // event, movie, wallet
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->json('order_payload'); // full selectedTicket/seat data
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_orders');
    }
};
