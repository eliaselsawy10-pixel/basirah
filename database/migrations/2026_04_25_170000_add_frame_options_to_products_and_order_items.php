<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add per-product frame configuration (materials, colors, sizes)
     * and snapshot columns on order_items so the customer's choice is recorded.
     */
    public function up(): void
    {
        // ── Products: store available options as JSON ──────────────
        Schema::table('products', function (Blueprint $table) {
            // e.g. ["Titanium Alloy","Premium Acetate"]
            $table->json('frame_materials')->nullable()->after('replacement');

            // e.g. [{"name":"Black","hex":"#1a1a2e"},{"name":"Silver","hex":"#e8e4df"},{"name":"Gunmetal","hex":"#b0b8c4"}]
            $table->json('frame_colors')->nullable()->after('frame_materials');

            // e.g. [{"value":"small","label":"Small (48-18)"},{"value":"standard","label":"Standard (51-19)"},{"value":"large","label":"Large (54-20)"}]
            $table->json('frame_sizes')->nullable()->after('frame_colors');
        });

        // ── Order Items: record what the customer chose ───────────
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('frame_material')->nullable()->after('purchase_type');
            $table->string('frame_color')->nullable()->after('frame_material');
            $table->string('frame_size')->nullable()->after('frame_color');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['frame_materials', 'frame_colors', 'frame_sizes']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['frame_material', 'frame_color', 'frame_size']);
        });
    }
};
