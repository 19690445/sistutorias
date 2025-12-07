<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'users_id',
        'matricula',
        'nombre',
        'apellidos',
        'correo_institucional',
        'carrera',
        'semestre',
        'estado'
    ];
}
