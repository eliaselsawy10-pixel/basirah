<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // e.g. "Light Blue" | "Grey" | "Brown" | "Amber" | "Violet"
            $table->string('color_family')->nullable()->after('face_shapes');
            
            // e.g. "Daily" | "Monthly" | "Yearly"
            $table->string('replacement')->nullable()->after('color_family');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['color_family', 'replacement']);
        });
    }
};
