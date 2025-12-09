<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $table = 'diagnosticos';
    
    protected $fillable = [
        'grupos_id',
        'periodo_id',
        'problemarios',
        'solucion',
        'objetivos',
        'fecha_realizacion',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_realizacion' => 'date',
    ];

   
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupos_id');
    }

   
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

  
    public function indicadores()
    {
        return $this->hasMany(Indicador::class, 'diagnosticos_id');
    }

    public function getEstadoTextoAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->estado));
    }
  
    public function getFechaRealizacionFormateadaAttribute()
    {
        return $this->fecha_realizacion 
            ? $this->fecha_realizacion->format('d/m/Y') 
            : 'No asignada';
    }
}