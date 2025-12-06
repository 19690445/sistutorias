<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Diagnostico;

class DiagnosticoPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role->nombre, ['coordinador', 'docente', 'tutorado']);
    }

    public function create(User $user)
    {
        return $user->role->nombre === 'docente';
    }

    public function update(User $user, Diagnostico $diagnostico)
    {
        
        if ($user->role->nombre === 'tutorado') {
            return $user->estudiante && $user->estudiante->grupo_id === $diagnostico->grupos_id;
        }

      
        if ($user->role->nombre === 'docente') {
            return $user->tutor && $diagnostico->grupo->tutores_id === $user->tutor->id;
        }

        return false;
    }

    public function view(User $user, Diagnostico $diagnostico)
    {
        return $this->update($user, $diagnostico) || $user->role->nombre === 'coordinador';
    }
}
