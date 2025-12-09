<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pat extends Model
{
    use HasFactory;

    protected $fillable = [
    'actividad',
    'tutores_id',
    'grupos_id',
    'responsable',
    'semana_planeada',
    'semana_real',
    'estado',
];


    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutores_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupos_id');
    }
}
