<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodo';

    protected $fillable = [
        'nombre_periodo',
        'año_periodo',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
        
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'periodo_id');
    }
}
