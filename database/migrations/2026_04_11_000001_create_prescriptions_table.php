<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create the prescriptions table.
     * Stores manually entered OR uploaded prescription data per user session/user.
     */
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();

            // Foreign key to users (nullable for guest checkout)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Foreign key to product being purchased
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            // Right Eye (OD) refraction values
            $table->string('od_sph', 8)->nullable();   // e.g. +1.25, -2.00
            $table->string('od_cyl', 8)->nullable();   // e.g. -0.75
            $table->integer('od_axis')->nullable();    // 0 – 180

            // Left Eye (OS) refraction values
            $table->string('os_sph', 8)->nullable();
            $table->string('os_cyl', 8)->nullable();
            $table->integer('os_axis')->nullable();

            // Pupillary Distance (mm)
            $table->decimal('pd_value', 4, 1)->nullable();

            // Uploaded prescription image/PDF path
            $table->string('prescription_file')->nullable();

            // Type: 'eyeglasses' | 'contact'
            $table->enum('type', ['eyeglasses', 'contact'])->default('eyeglasses');

            // Status: draft | submitted | processed
            $table->enum('status', ['draft', 'submitted', 'processed'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
