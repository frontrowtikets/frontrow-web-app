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
            $table->boolean('beneficiary_credited')->default(false)->after('ticket_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_tickets', function (Blueprint $table) {
            $table->dropColumn('beneficiary_credited');
        });
    }
};
