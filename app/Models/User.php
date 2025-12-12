<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

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
   
    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'users_id');
    }

     public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCoordinador()
    {
        return $this->role === 'coordinador';
    }

    public function isDocente()
    {
        return $this->role === 'docente';
    }

    public function isTutorado()
    {
        return $this->role === 'tutorado';
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }


}
