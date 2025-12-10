<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    protected $table = 'individuales';
    
    protected $fillable = [
        'periodo_id',
        'tutores_id',
        'estudiantes_id',
        'requiere_canalizacion',
        'motivo',
        'estado',
    ];
    
    protected $casts = [
        'requiere_canalizacion' => 'string',
        'estado' => 'string',
    ];
    
    
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
    
   
    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutores_id');
    }
    
   
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiantes_id');
    }
    
    
    public function canalizaciones()
    {
        return $this->hasMany(Canalizacion::class, 'individuales_id');
    }
    
    
    public function scopeRequiereCanalizacion($query)
    {
        return $query->where('requiere_canalizacion', 'si');
    }
    
    
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
}