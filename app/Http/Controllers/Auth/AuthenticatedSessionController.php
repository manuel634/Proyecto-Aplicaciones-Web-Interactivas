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

        // Verificar el rol del usuario para redirigir según corresponda
        $role = Auth::user()->idRol;

        // Redirigir al administrador
        if ($role == 1) {
            return redirect()->route('admin.users.index');
        }

        // Redirigir al doctor a la vista de citas
        if ($role == 2) {
            return redirect()->route('appointments.doctors.index');
        }

        // Redirigir al paciente a la vista de citas
        if ($role == 3) {
            return redirect()->route('appointments.index');
        }

        // Si el rol no es reconocido, redirigir a una página predeterminada
        return redirect()->route('dashboard');
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
