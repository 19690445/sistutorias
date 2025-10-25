<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Tus políticas aquí
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define("gestionar-usuarios", function ($user) {
            return $user->hasRole("admin");
        });
        Gate::define("cambiar-configuracion", function ($user) {
            return $user->hasRole("admin");
        });

        Gate::define("gestionar-tutorados", function ($user) {
            return $user->hasRole(["admin", "tutor"]);
        });
    }
}