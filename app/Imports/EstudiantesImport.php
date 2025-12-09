<?php

namespace App\Imports;

use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudiantesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        
        $user = User::create([
            'name' => $row['nombre'] . ' ' . $row['apellidos'],
            'email' => $row['correo_institucional'],
            'password' => Hash::make('12345678'), 
            'rol' => 'estudiante', 
        ]);

       
        $grupo = Grupo::where('clave_grupo', $row['clave_grupo'])->first();

       
        return new Estudiante([
            'users_id' => $user->id,
            'grupo_id' => $grupo?->id,
            'matricula' => $row['matricula'],
            'nombre' => $row['nombre'],
            'apellidos' => $row['apellidos'],
            'correo_institucional' => $row['correo_institucional'],
            'carrera' => $row['carrera'] ?? null,
            'semestre' => $row['semestre'] ?? null,
            'estado' => 'activo',
        ]);
    }
}
