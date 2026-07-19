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
        // dd('TAKUNCI NGNA');
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi user
        $request->authenticate();

        // Regenerasi session untuk keamanan (mencegah session fixation)
        $request->session()->regenerate();

        // Tarik data role dari user yang baru saja login
        $role = $request->user()->role;

        // Tentukan arah redirect berdasarkan role
        $redirectUrl = match ($role) {
            'admin'      => route('editor.dashboard', absolute: false),
            'teologi'      => route('admin.dashboard', absolute: false),
            'linguistik'      => route('admin.dashboard', absolute: false),
            'editor'     => route('editor.dashboard', absolute: false),
            

            default      => '/', // Fallback kalau ada role aneh atau user biasa
        };

        // intended() fungsinya biar kalau user sebelumnya mau buka halaman spesifik tapi disuruh login dulu, 
        // dia bakal dikembaliin ke halaman itu. Kalau nggak ada, dia lari ke $redirectUrl.
        return redirect()->intended($redirectUrl);
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
