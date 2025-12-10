<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canalizacion extends Model
{
    protected $table = 'canalizaciones';

    protected $fillable = [
        'individuales_id',
        'tipo_atencion',
        'causa_problema',
        'acciones_sugeridas',
        'primera_sesion_propuesta',
        'primera_sesion_real',
        'seguimiento_tutor',
        'estado',
        'observaciones'
    ];

    public function individual()
    {
        return $this->belongsTo(Individual::class, 'individuales_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
    
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
    
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}
