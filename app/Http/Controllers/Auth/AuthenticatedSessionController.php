<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.loginregister');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        Log::info('Login attempt for: ' . $credentials['email']);

        // Try to authenticate with email or username
        $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $loginCredentials = [
            $loginField => $credentials['email'],
            'password' => $credentials['password']
        ];

        if (Auth::attempt($loginCredentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            Log::info('User authenticated: ' . $user->email . ' with role: ' . $user->role);
            Log::info('User ID: ' . $user->id);

            // Redirect based on role
            switch (strtolower($user->role)) {
                case 'customer':
                    Log::info('Redirecting customer to shop');
                    return redirect()->intended('/shop');
                
                case 'administrator':
                case 'employee':
                case 'technician':
                    Log::info('Redirecting ' . $user->role . ' to dashboard');
                    return redirect()->intended('/dashboard');
                
                default:
                    Log::info('Unknown role: ' . $user->role . ', redirecting to dashboard');
                    return redirect()->intended('/dashboard');
            }
        }

        Log::info('Authentication failed for: ' . $credentials['email']);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginregister');
    }
}