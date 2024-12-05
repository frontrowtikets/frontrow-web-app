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
        // Schema::create('wallet_transactions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->decimal('amount', total: 12);
        //     $table->string('transaction_type', 100);
        //     $table->string('reference', 100);
        //     $table->longText('description')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
         Schema::dropIfExists('wallet_transactions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
