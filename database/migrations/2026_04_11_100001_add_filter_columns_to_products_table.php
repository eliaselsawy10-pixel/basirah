<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Add filterable columns to the products table.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Frame material  e.g. "Pure Titanium" | "Eco-Acetate" | "Lightweight Metal"
            $table->string('material')->nullable()->after('is_best_seller');

            // Brand  e.g. "Ray-Ban" | "Gucci" | "Versace"
            $table->string('brand')->nullable()->after('material');

            // Face shape suitability  e.g. "oval,round" (comma-separated or JSON)
            $table->string('face_shapes')->nullable()->after('brand');

            // New arrivals flag (for quick filter)
            $table->boolean('is_new_arrival')->default(false)->after('face_shapes');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['material', 'brand', 'face_shapes', 'is_new_arrival']);
        });
    }
};
