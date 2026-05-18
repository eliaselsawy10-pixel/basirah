<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session ID after login to prevent session fixation attacks (keeps session data intact)
            $request->session()->regenerate();

            // Redirect doctors to their dashboard
            if (Auth::user()->isDoctor()) {
                return redirect()->intended('/doctor/dashboard');
            }

            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }


        // Authentication failed — redirect back with errors
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

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

        // Regenerate CSRF token after logout so that any previously opened pages, old forms,
        // or attempts to reuse an old session become invalid and cannot be used again for security reasons
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

