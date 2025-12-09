<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodo';

    protected $fillable = [
        'estudiantes_id',
        'nombre_periodo',
        'año_periodo',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
    ];

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiantes_id');
    }

    
}
