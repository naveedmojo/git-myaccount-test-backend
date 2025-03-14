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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('used_years')->nullable();
            $table->boolean('is_with_games')->default(false);
            $table->boolean('is_limited_edition')->default(false);
            $table->boolean('is_sold')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['used_years', 'is_with_games', 'is_limited_edition','is_sold']);
        });
    }
};
