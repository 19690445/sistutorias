<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    /**
     * Redirección según el rol después del login.
     */
    protected function authenticated(Request $request, $user)
    {
        // Si no tiene rol asignado
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['error' => 'Tu usuario no tiene un rol asignado.']);
        }

        // Redirigir según el rol
        return match ($user->role->nombre) {
            'admin'       => redirect()->route('admin.dashboard'),
            'docente'     => redirect()->route('docente.dashboard'),
            'coordinador' => redirect()->route('coordinador.dashboard'),
            'tutorado'    => redirect()->route('tutorado.dashboard'),
            
        };
    }
}
