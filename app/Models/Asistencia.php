<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutores_id',
        'estudiantes_id',
        'periodo_id',
        'sesion',
        'fecha',
        'estado',
        'observaciones'
    ];

    public function grupo()
{
    return $this->belongsTo(Grupo::class, 'grupo_id');
}

public function tutor()
{
    return $this->belongsTo(Tutor::class, 'tutores_id');
}

public function estudiante()
{
    return $this->belongsTo(Estudiante::class, 'estudiantes_id');
}

public function periodo()
{
    return $this->belongsTo(Periodo::class, 'periodo_id');
}

}
