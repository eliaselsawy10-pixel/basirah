<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create the appointments (doctor consultations) table.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();

            // Patient contact info (for guest bookings)
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('patient_phone', 30)->nullable();

            // Appointment scheduling
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('time_slot', 20)->nullable()->comment('Display slot e.g. "09:00 AM"');

            // Reason / notes
            $table->string('consultation_type')->nullable();
            $table->text('notes')->nullable();

            // Payment
            $table->decimal('price_paid', 8, 2)->default(0)->comment('Amount paid for the consultation');

            // Status lifecycle
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('pending');

            // Meeting / video consultation
            $table->string('meeting_token', 64)->nullable()->unique()->comment('Random token for building the Jitsi Meet link');
            $table->string('meeting_url', 255)->nullable()->comment('Full Jitsi Meet URL for the consultation');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
