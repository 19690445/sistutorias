<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Diagnostico::class => \App\Policies\DiagnosticoPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define("gestionar-usuarios", function ($user) {
            return $user->hasRole("admin");
        });

        Gate::define("gestionar-tutorados", function ($user) {
            return $user->hasRole(["admin", "tutor",]);
        });

         Gate::define("crear-grupos", function ($user) {
            return $user->hasRole(["admin", "coordinador"]);
        });

         Gate::define("ver-usuarios", function ($user) {
            return $user->hasRole("admin");
        });

        Gate::define("gestionar-estudiantes", function ($user) {
            return $user->hasRole("admin");
        });

        Gate::define("ver-periodos", function ($user) {
            return $user->hasRole(["admin", "coordinador"]);
        });

        Gate::define("ver-diagnosticos", function ($user) {
            return $user->hasRole(["admin", "coordinador", "docente"]);
        });

        Gate::define("ver-individuales", function ($user) {
            return $user->hasRole(["admin", "coordinador", "docente"]);
        });

        Gate::define("ver-asistencia", function ($user) {
            return $user->hasRole(["admin", "coordinador", "docente"]);
        });

        Gate::define("crear-docente", function ($user) {
            return $user->hasRole(["admin", "coordinador",]);
        });

        Gate::define("ver-informacion", function ($user) {
            return $user->hasRole(["admin", "coordinador"]);
        });

         Gate::define("ver-canalizaciones", function ($user) {
            return $user->hasRole(["admin", "coordinador", "docente", ]);
        });

        Gate::define("ver-pats", function ($user) {
            return $user->hasRole(["admin", "coordinador", "docente"]);
        });

        Gate::define("perfil-docente", function ($user) {
            return $user->hasRole(["docente",]);
        });

         Gate::define("perfil-estudiante", function ($user) {
            return $user->hasRole(["tutorado",]);
        });
    }

}