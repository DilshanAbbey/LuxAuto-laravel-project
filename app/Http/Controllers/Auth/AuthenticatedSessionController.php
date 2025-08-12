<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            Log::info('User authenticated: ' . $user->email . ' with role: ' . $user->role);

            // Redirect based on role
            switch (strtolower($user->role)) {
                case 'customer':
                    Log::info('Redirecting customer to shop');
                    return redirect('/shop');
                
                case 'administrator':
                case 'employee':
                case 'technician':
                    Log::info('Redirecting ' . $user->role . ' to dashboard');
                    return redirect('/dashboard');
                
                default:
                    Log::info('Unknown role: ' . $user->role . ', redirecting to dashboard');
                    return redirect('/dashboard');
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
