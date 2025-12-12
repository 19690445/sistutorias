<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAT extends Model
{
    use HasFactory;

    protected $table = 'pats';
    
    protected $fillable = [
        'tutores_id',
        'grupos_id',
        'periodo_id',
        'actividad',
        'responsable',
        'semana_planeada',
        'semana_real',
        'estado'
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutores_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupos_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
    
    
    public function getSemanasRealesArrayAttribute()
    {
        if (empty($this->semana_real)) {
            return [];
        }
        return explode(',', $this->semana_real);
    }
    
    public function getSemanasPlaneadasArrayAttribute()
    {
        if (empty($this->semana_planeada)) {
            return [];
        }
        return explode(',', $this->semana_planeada);
    }
}