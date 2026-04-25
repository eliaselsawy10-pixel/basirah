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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Role: patient (default) or doctor
            $table->enum('role', ['patient', 'doctor'])->default('patient');

            // Doctor-specific fields (nullable for patients)
            $table->string('title')->nullable();              // e.g. "Senior Optometrist"
            $table->text('bio')->nullable();                   // Short biography
            $table->decimal('price', 8, 2)->nullable();        // Session price  e.g. 45.00
            $table->float('rating')->default(0);               // Average rating  e.g. 4.9
            $table->unsignedInteger('review_count')->default(0); // Total reviews
            $table->string('image')->nullable();               // Avatar path
            $table->json('specializations')->nullable();       // ["Vision Therapy", "Dry Eye Specialist"]

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
