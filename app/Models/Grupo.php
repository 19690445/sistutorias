<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'clave_grupo',
        'nombre_grupo',
        'tutores_id',
        'periodo_id',
        'carrera',
        'semestre',
        'aula',
        'horario',
        'capacidad_salon',
        'modalidad',
        'turno',
    ];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'grupo_id');
    }
     public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutores_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function tutorados()
    {
        return $this->hasMany(Tutorado::class);
    }

   
    public function pats()
    {
        return $this->hasMany(PAT::class, 'grupos_id');
    }
}
