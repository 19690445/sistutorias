<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * Atributos que deben estar ocultos en arrays o JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relación con el modelo Role.
     * Un usuario pertenece a un rol.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Verifica si el usuario tiene un rol determinado.
     */
    public function hasRole($roles)
    {
        $userRole = $this->role?->nombre;

        if (!$userRole) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($userRole, $roles);
        }

        return $userRole === $roles;
    }
    public function user()
{
    return $this->belongsTo(User::class, 'users_id'); 
}

}
