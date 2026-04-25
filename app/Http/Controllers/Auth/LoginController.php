<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirect doctors to their dashboard
            if (Auth::user()->isDoctor()) {
                return redirect()->intended('/doctor/dashboard');
            }

            return redirect()->intended('/');
        }

        // Authentication failed — redirect back with errors
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     *
     * Clean up any abandoned 'submitted' prescriptions before
     * flushing the session. 'Ordered' records stay as history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Delete abandoned prescriptions (never ordered) for this user
        if (Auth::check()) {
            Prescription::where('user_id', Auth::id())
                ->where('status', 'submitted')
                ->delete();
        }

        Auth::logout();

        // Flushes ALL session data: cart, prescription, lens_order, etc.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

