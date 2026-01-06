<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        \Log::info('Login successful for user: ' . $user->id . ', role: ' . $user->role);

        // Role-based redirect
        if ($user->role === 'brand_owner') {
            \Log::info('Redirecting brand_owner to brand.dashboard');
            return redirect()->intended(route('brand.dashboard', absolute: false));
        } elseif ($user->role === 'admin') {
            \Log::info('Redirecting admin to admin.dashboard');
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } else {
            \Log::info('Redirecting user to explore');
            return redirect()->intended(route('explore.index', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
