<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $user = Auth::user();

            switch ($user->role->nombre ?? null) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'docente':
                    return redirect('/docente/dashboard');
                case 'coordinador':
                    return redirect('/coordinador/dashboard');
                case 'tutorado':
                    return redirect('/tutorado.dashboard');
            }
        }

        return $next($request);
    }
}
