<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Simplify the prescriptions table:
     * 1. Convert all legacy statuses → 'submitted'
     * 2. Collapse the ENUM to only ('submitted', 'ordered')
     * 3. Drop the unused 'prescription_file' column
     */
    public function up(): void
    {
        // Step 1: Normalize any legacy status values to 'submitted'
        DB::table('prescriptions')
            ->whereIn('status', ['draft', 'pending', 'processed'])
            ->update(['status' => 'submitted']);

        // Step 2: Redefine the ENUM with only the two meaningful statuses
        DB::statement("ALTER TABLE prescriptions MODIFY COLUMN status ENUM('submitted', 'ordered') DEFAULT 'submitted'");

        // Step 3: Drop the unused prescription_file column
        Schema::table('prescriptions', function (Blueprint $table) {
            if (Schema::hasColumn('prescriptions', 'prescription_file')) {
                $table->dropColumn('prescription_file');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE prescriptions MODIFY COLUMN status ENUM('draft', 'submitted', 'processed', 'pending', 'ordered') DEFAULT 'pending'");

        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('prescription_file')->nullable()->after('pd_value');
        });
    }
};
