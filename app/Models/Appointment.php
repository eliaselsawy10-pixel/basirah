<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'appointment_date',
        'appointment_time',
        'time_slot',
        'consultation_type',
        'notes',
        'price_paid',
        'status',
        'meeting_token',
        'meeting_url',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'price_paid' => 'decimal:2',
    ];

    /**
     * The user (patient) who made the appointment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The doctor (user with role=doctor) for this appointment.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Check if the current time falls within the meeting window.
     * Window: 15 minutes before → 45 minutes after start time.
     */
    public function isMeetingTime(): bool
    {
        $start = Carbon::parse(
            $this->appointment_date->format('Y-m-d') . ' ' . $this->appointment_time
        );

        $windowStart = $start->copy()->subMinutes(15);
        $windowEnd = $start->copy()->addMinutes(45);

        return Carbon::now()->between($windowStart, $windowEnd);
    }

    /**
     * Check if the patient/doctor can join the meeting.
     */
    public function canJoinMeeting(): bool
    {
        return $this->meeting_url
            && in_array($this->status, ['pending', 'confirmed'])
            && $this->isMeetingTime();
    }

    /**
     * Minutes remaining until the meeting window opens.
     * Returns 0 if window is already open or passed.
     */
    public function minutesUntilMeeting(): int
    {
        $start = Carbon::parse(
            $this->appointment_date->format('Y-m-d') . ' ' . $this->appointment_time
        );

        $windowStart = $start->copy()->subMinutes(15);
        $now = Carbon::now();

        if ($now->gte($windowStart)) {
            return 0;
        }

        return (int) $now->diffInMinutes($windowStart);
    }

    /**
     * Check if the appointment is in the past (meeting window has ended).
     */
    public function isPast(): bool
    {
        $start = Carbon::parse(
            $this->appointment_date->format('Y-m-d') . ' ' . $this->appointment_time
        );

        return Carbon::now()->gt($start->copy()->addMinutes(45));
    }
}
