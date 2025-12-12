<?php

namespace App\Http\Controllers;

use App\Models\EntrevistaIndividual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrevistaIndividualController extends Controller
{
    public function create()
    {
        return view('entrevistas.create'); // no necesitas pasar $estudiantes si no es obligatorio
    }

    public function store(Request $request)
    {
        // Guardamos el usuario autenticado
        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Si estudiante_id viene vacío, dejamos null
        if(empty($data['estudiante_id'])) {
            $data['estudiante_id'] = null;
        }

        $entrevista = EntrevistaIndividual::create($data);

        // Redirigir al siguiente formulario (o volver al mismo para continuar)
        return redirect()->route('entrevistas.create')
                         ->with('success', 'Datos guardados. Puedes continuar con la siguiente entrevista.');
    }
}
