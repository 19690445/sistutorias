<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Si el usuario no está autenticado → redirige al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Si no tiene rol asignado → cerrar sesión y avisar
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['error' => 'Tu usuario no tiene un rol asignado.']);
        }

        // Si el rol no coincide con el exigido por la ruta
        if ($user->role->nombre !== $role) {
            // 🔹 Redirigirlo a su propio dashboard, en lugar de abortar
            switch ($user->role->nombre) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'docente':
                    return redirect()->route('docente.dashboard');
                case 'coordinador':
                    return redirect()->route('coordinador.dashboard');
                case 'tutorado':
                    return redirect()->route('tutorado.dashboard');
            }
        }

        // Si todo está bien → permitir el acceso
        return $next($request);
    }
}
