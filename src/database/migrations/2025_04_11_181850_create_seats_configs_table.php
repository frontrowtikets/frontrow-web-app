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
        Schema::create('seats_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_map_config_tables_id')->constrained()->cascadeOnDelete();
            $table->string('row');
            $table->string('seat_count');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats_configs');
    }
};
