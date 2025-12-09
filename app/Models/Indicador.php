<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    use HasFactory;

    protected $table = 'indicadores';
    
    protected $fillable = [
        'diagnosticos_id',
        'causa',
        'clave_indicadora',
        'descripcion',
        'meta',
        'fecha_registro',
        'estado',
        'notas'
    ];

   protected $casts = [
    'fecha_registro' => 'date',
    ];
    public function diagnostico()
    {
        return $this->belongsTo(Diagnostico::class, 'diagnosticos_id');
    }

 
    public function getEstadoTextoAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'completado' => 'Completado',
            'no_aplica' => 'No Aplica'
        ];
        
        return $estados[$this->estado] ?? ucfirst(str_replace('_', ' ', $this->estado));
    }
}