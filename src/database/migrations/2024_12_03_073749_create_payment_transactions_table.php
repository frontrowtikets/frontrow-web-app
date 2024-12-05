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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id('id');
            $table->string('txn_ref', 100);
            $table->string('mfscode', 100);
            $table->string('txn_type', 50)->default('ticket_purchase');
            $table->string('txn_channel', 50)->default('web');
            $table->string('txn_status', 20)->default('pending');
            $table->bigInteger('amount');
            $table->string('currency', 5)->default("UGX");
            $table->string('reason');
            $table->string('phone_number', 14);
            $table->foreignId('user_id')->constrained();
            $table->string('txn_hash', 64);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
