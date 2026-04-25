<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    /**
     * Show the consultation/booking page with all doctors.
     */
    public function index()
    {
        $doctors = User::where('role', 'doctor')->orderBy('name')->get();

        return view('consultations.index', compact('doctors'));
    }

    /**
     * AJAX — Return available time slots for a doctor on a given date.
     *
     * GET /appointments/slots?doctor_id=1&date=2026-04-18
     */
    public function availableSlots(Request $request): JsonResponse
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date'      => 'required|date|after_or_equal:today',
        ]);

        // Fixed daily time slots
        $allSlots = [
            '09:00 AM',
            '10:30 AM',
            '10:00 PM',
            '03:00 PM',
        ];

        // Slots already booked for this doctor + date (non-cancelled)
        $bookedSlots = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date)
            ->where('status', '!=', 'cancelled')
            ->pluck('time_slot')
            ->toArray();

        $available = array_values(array_diff($allSlots, $bookedSlots));

        return response()->json([
            'date'      => $request->date,
            'doctor_id' => (int) $request->doctor_id,
            'slots'     => $available,
        ]);
    }

    /**
     * AJAX — Book an appointment.
     *
     * POST /appointments
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'doctor_id'        => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot'        => 'required|string',
            'patient_name'     => 'required|string|max:255',
            'patient_email'    => 'required|email|max:255',
            'patient_phone'    => 'nullable|string|max:30',
        ]);

        // ── Double-check the slot is still free ──────────────────────
        $alreadyTaken = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('time_slot', $validated['time_slot'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyTaken) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, that time slot has just been taken. Please choose another.',
            ], 409);
        }

        // ── Resolve price from doctor (user) ─────────────────────────
        $doctor = User::where('id', $validated['doctor_id'])->where('role', 'doctor')->firstOrFail();

        // ── Generate meeting token & URL ─────────────────────────────
        $meetingToken = Str::random(32);
        $meetingUrl   = 'https://meet.jit.si/basirah-' . $meetingToken;

        // ── Create the appointment ───────────────────────────────────
        $appointment = Appointment::create([
            'user_id'          => auth()->id(),
            'doctor_id'        => $doctor->id,
            'patient_name'     => $validated['patient_name'],
            'patient_email'    => $validated['patient_email'],
            'patient_phone'    => $validated['patient_phone'] ?? null,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $this->slotToTime($validated['time_slot']),
            'time_slot'        => $validated['time_slot'],
            'price_paid'       => $doctor->price,
            'status'           => 'pending',
            'meeting_token'    => $meetingToken,
            'meeting_url'      => $meetingUrl,
        ]);

        // ── Store patient email in session for guest lookup ──────────
        $bookedEmails = session('booked_emails', []);
        if (!in_array($validated['patient_email'], $bookedEmails)) {
            $bookedEmails[] = $validated['patient_email'];
            session(['booked_emails' => $bookedEmails]);
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Appointment booked successfully!',
            'appointment' => $appointment->only('id', 'appointment_date', 'time_slot', 'price_paid', 'status', 'meeting_url'),
        ], 201);
    }

    /**
     * Show "My Appointments" page for patients.
     */
    public function myAppointments(Request $request)
    {
        $query = Appointment::with('doctor')->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc');

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $bookedEmails = session('booked_emails', []);
            if (empty($bookedEmails)) {
                $appointments = collect();
                return view('consultations.my-appointments', compact('appointments'));
            }
            $query->whereIn('patient_email', $bookedEmails);
        }

        $appointments = $query->get();

        return view('consultations.my-appointments', compact('appointments'));
    }

    /**
     * Show the Doctor Dashboard — appointments assigned to the logged-in doctor.
     */
    public function doctorDashboard()
    {
        $doctor = auth()->user();

        if (!$doctor || !$doctor->isDoctor()) {
            abort(403, 'Access denied. Doctor account required.');
        }

        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_time')
            ->get();

        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $pastAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where(function ($q) {
                $q->whereDate('appointment_date', '<', today())
                  ->orWhere('status', 'completed');
            })
            ->orderBy('appointment_date', 'desc')
            ->limit(10)
            ->get();

        return view('consultations.doctor-dashboard', compact('doctor', 'todayAppointments', 'upcomingAppointments', 'pastAppointments'));
    }

    /**
     * Join a consultation meeting — redirect to Jitsi Meet.
     */
    public function joinMeeting(string $token)
    {
        $appointment = Appointment::where('meeting_token', $token)->firstOrFail();

        if (!$appointment->canJoinMeeting()) {
            $redirectRoute = auth()->check() && auth()->user()->isDoctor()
                ? 'doctor.dashboard'
                : 'appointments.my';

            return redirect()->route($redirectRoute)
                ->with('error', 'The consultation link is not active yet. It will be available 15 minutes before your appointment time.');
        }

        return redirect()->away($appointment->meeting_url);
    }

    /**
     * Convert a display slot (e.g. "09:00 AM") to a 24-hour time ("09:00:00").
     */
    private function slotToTime(string $slot): string
    {
        return date('H:i:s', strtotime($slot));
    }
}
