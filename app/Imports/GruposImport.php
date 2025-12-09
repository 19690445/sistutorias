<?php

namespace App\Imports;

use App\Models\Grupo;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GruposImport implements ToModel
{
    public function model(array $row)
    {
        return new Grupo([
            'clave_grupo' => $row[0],
            'nombre_grupo' => $row[1] ?? 'SIN NOMBRE',
            'tutores_id' => $row[2] ?? 1,
            'periodo_id' => $row[3] ?? 1,
            'carrera' => $row[4] ?? 'SIN CARRERA',
            'semestre' => $row[5] ?? 1,
            'aula' => $row[6] ?? null,
            'horario' => $row[7] ?? null,
            'capacidad_salon' => $row[8] ?? null,
            'modalidad' => $row[9] ?? 'presencial',
            'turno' => $row[10] ?? 'matutino',
        ]);
    }
}
