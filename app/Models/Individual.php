<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    use HasFactory;

    protected $table = 'individuales'; 

    protected $fillable = [
        'periodo_id',
        'tutores_id',
        'estudiantes_id',
        'requiere_canalizacion',
        'motivo',
        'estado',
    ];

    public function canalizaciones()
    {
        return $this->hasMany(Canalizacion::class, 'individuales_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiantes_id');
    }
}

