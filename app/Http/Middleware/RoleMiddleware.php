<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['error' => 'Tu usuario no tiene un rol asignado.']);
        }

       
        $userRole = $user->role->nombre;

        if (!in_array($userRole, $roles)) {

            switch ($userRole) {
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

        return $next($request);
    }
}
