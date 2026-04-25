<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add an enhancements JSON column to order_items
     * to store recommended enhancements selected on the select-lenses page.
     * Format: [{"name": "Anti-Reflective Coating", "price": 25.00}, ...]
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->json('enhancements')->nullable()->after('lens_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('enhancements');
        });
    }
};
