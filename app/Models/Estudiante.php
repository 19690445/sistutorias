<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'apellidos', 'grupo', 'tutor_id', 'users_id'
    ];

    
    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
