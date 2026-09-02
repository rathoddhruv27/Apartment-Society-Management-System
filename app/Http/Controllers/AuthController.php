<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Switch authenticated user quickly (for demo/testing role features).
     */
    public function switchRole(Request $request)
    {
        $request->validate([
            'role_slug' => ['required', 'string', 'in:master-admin,admin,user,security-guard'],
        ]);

        $user = User::whereHas('role', function ($query) use ($request) {
            $query->where('slug', $request->role_slug);
        })->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', "Switched role to: {$user->role->name}");
        }

        return back()->with('error', 'No user found with the requested role.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
