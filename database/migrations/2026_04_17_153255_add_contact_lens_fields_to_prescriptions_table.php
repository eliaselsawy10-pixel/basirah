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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->decimal('od_bc', 4, 2)->nullable()->after('os_axis');
            $table->decimal('od_dia', 4, 2)->nullable()->after('od_bc');
            $table->decimal('os_bc', 4, 2)->nullable()->after('od_dia');
            $table->decimal('os_dia', 4, 2)->nullable()->after('os_bc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['od_bc', 'od_dia', 'os_bc', 'os_dia']);
        });
    }
};
