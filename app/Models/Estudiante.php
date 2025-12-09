<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'users_id',
        'grupo_id',
        'matricula',
        'nombre',
        'email',
        'carrera',
        
    ];

   public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
    
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'estudiantes_id');
    }
}



                    