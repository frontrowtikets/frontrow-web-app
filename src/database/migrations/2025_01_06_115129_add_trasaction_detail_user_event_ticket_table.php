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
            $table->foreignId('user_payment_detail_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_transaction_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_event_tickets', function (Blueprint $table) {
            $table->dropColumn(['user_payment_detail_id', 'payment_transaction_id', 'quantity']);
        });
    }
};
