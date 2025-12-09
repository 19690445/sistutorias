<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    
    protected $fillable = [
        'tutores_id',
        'estudiantes_id',
        'grupo_id',
        'periodo_id',
        'sesion',
        'fecha',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutores_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiantes_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}