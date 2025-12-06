<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupos_id',
        'periodo_id',
        'problemarios',
        'solucion',
        'objetivos',
        'fecha_realizacion',
        'estado',
        'observaciones',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupos_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
}
