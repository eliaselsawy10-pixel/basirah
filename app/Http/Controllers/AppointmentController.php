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
            'date' => 'required|date|after_or_equal:today',
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
            'date' => $request->date,
            'doctor_id' => (int) $request->doctor_id,
            'slots' => $available,
        ]);
    }

    /**
     * AJAX — Reserve an appointment slot (store in session, don't create yet).
     *
     * The appointment is NOT created in the database here. Instead, the booking
     * data is saved in the session and the user is redirected to the appointment
     * checkout page to complete payment before the appointment is confirmed.
     *
     * POST /appointments
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'nullable|string|max:30',
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

        // ── Resolve doctor info ──────────────────────────────────────
        $doctor = User::where('id', $validated['doctor_id'])->where('role', 'doctor')->firstOrFail();

        // ── Store booking data in session (not in DB yet) ────────────
        session()->put('appointment_booking', [
            'doctor_id' => $doctor->id,
            'doctor_name' => $doctor->name,
            'doctor_image' => $doctor->image,
            'doctor_title' => $doctor->title,
            'appointment_date' => $validated['appointment_date'],
            'time_slot' => $validated['time_slot'],
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'] ?? null,
            'price' => $doctor->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Redirecting to payment...',
            'redirect' => route('appointments.checkout'),
        ], 200);
    }

    /**
     * Show the appointment checkout/payment page.
     *
     * GET /appointments/checkout
     */
    public function checkout()
    {
        $booking = session('appointment_booking');

        if (!$booking) {
            return redirect()->route('appointments.index')
                ->with('error', 'No appointment booking found. Please select a doctor and time slot.');
        }

        return view('consultations.appointment-checkout', compact('booking'));
    }

    /**
     * Process the appointment payment and create the appointment.
     *
     * POST /appointments/checkout
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,digital_wallets',
        ]);

        $booking = session('appointment_booking');

        if (!$booking) {
            return redirect()->route('appointments.index')
                ->with('error', 'No appointment booking found. Please try again.');
        }

        // ── Double-check the slot is STILL free ──────────────────────
        $alreadyTaken = Appointment::where('doctor_id', $booking['doctor_id'])
            ->where('appointment_date', $booking['appointment_date'])
            ->where('time_slot', $booking['time_slot'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyTaken) {
            session()->forget('appointment_booking');
            return redirect()->route('appointments.index')
                ->with('error', 'Sorry, that time slot has just been taken by someone else. Please choose another.');
        }

        // ── Generate meeting token & URL ─────────────────────────────
        $meetingToken = Str::random(32);
        $meetingUrl = 'https://meet.jit.si/basirah-' . $meetingToken;

        // ── Create the appointment ───────────────────────────────────
        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'doctor_id' => $booking['doctor_id'],
            'patient_name' => $booking['patient_name'],
            'patient_email' => $booking['patient_email'],
            'patient_phone' => $booking['patient_phone'],
            'appointment_date' => $booking['appointment_date'],
            'appointment_time' => $this->slotToTime($booking['time_slot']),
            'time_slot' => $booking['time_slot'],
            'price_paid' => $booking['price'],
            'status' => 'confirmed',
            'meeting_token' => $meetingToken,
            'meeting_url' => $meetingUrl,
        ]);

        // ── Clear booking session ────────────────────────────────────
        session()->forget('appointment_booking');

        // ── Redirect with success ────────────────────────────────────
        return redirect()->route('appointments.my')
            ->with('success', 'Payment successful! Your appointment #' . $appointment->id . ' has been confirmed.');
    }

    /**
     * Show "My Appointments" page for patients.
     */
    public function myAppointments(Request $request)
    {
        $appointments = Appointment::with('doctor')
            ->where('user_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

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
