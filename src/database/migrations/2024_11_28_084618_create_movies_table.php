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
        Schema::create('movies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('beneficiary_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('duration')->nullable();
            $table->string('rating', 100)->nullable();
            $table->string('genre', 100)->nullable();
            $table->string('languange', 100)->nullable();
            $table->string('poster_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('status', 100);
            $table->string('movie_status', 100)->nullable();
            $table->string('currency', 100)->nullable();
            $table->string('maturity_rating')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
