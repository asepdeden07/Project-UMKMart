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
     * Display the login view (Milik Customer).
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request (Milik Customer).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // VALIDASI AMAN: Jika admin coba-coba login lewat form customer, tendang keluar
        if ($user->role === 'admin') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Admin tidak diizinkan masuk melalui jalur ini. Gunakan halaman login khusus admin.',
            ]);
        }

        // Jika dia benar customer, arahkan ke halaman home
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Display the login view khusus Admin.
     */
    public function createAdmin(): View
    {
        // Mengarah ke file resources/views/auth/admin-login.blade.php
        return view('auth.admin-login');
    }

    /**
     * Handle an incoming authentication request khusus Admin.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // VALIDASI AMAN: Pastikan hanya user dengan role admin yang boleh masuk lewat sini
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Jika customer/user biasa genit mencoba masuk lewat form admin, tendang keluar
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->withErrors([
            'email' => 'Akses ditolak. Halaman ini hanya diperuntukkan bagi akun Administrator.',
        ]);
    }

    /**
     * Destroy an authenticated session (Logout Universal).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}