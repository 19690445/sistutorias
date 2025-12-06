<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canalizacion extends Model
{
    use HasFactory;

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

    public function individuale()
    {
        return $this->belongsTo(Individual::class, 'individuales_id');
    }
}
