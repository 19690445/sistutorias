<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'matricula',
        'carrera',
        'semestre',
        // otros campos
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

}

