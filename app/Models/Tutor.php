<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tutor extends Model
{
    protected $table = 'tutores';

    protected $fillable = [
        'users_id',
        'nombre',
        'apellidos',
        'curp',
        'fecha_nacimiento',
        'sexo',
        'correo_electronico',
        'telefono',
        'departamento',
        'rfc',
        'nivel_estudios',
        'descripcion_estudios',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
