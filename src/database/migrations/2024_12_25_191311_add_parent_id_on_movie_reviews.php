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
        Schema::table('movie_reviews', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('parent_id')->nullable()->after('movie_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_reviews', function (Blueprint $table) {
            //
            $table->dropColumn('parent_id');
        });
    }
};
