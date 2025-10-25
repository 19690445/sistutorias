<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorado extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'users_id',
        'matricula',
        'nombre',
        'apellidos',
        'curp',
        'fecha_nacimiento',
        'genero',
        'correo_institucional',
        'telefono_celular',
        'domicilio',
        'carrera',
        'semestre',
        'estado',
        'fecha_ingreso',
        'fecha_egreso',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
