<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante; // Modelo correcto
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $tutorado = Estudiante::where('users_id', $user->id)->first();

        // Si no existe el tutorado, mostrar mensaje
        if (!$tutorado) {
            return view('tutorado.dashboard')->with('tutorado', null);
        }

        return view('tutorado.dashboard', compact('tutorado'));
    }
}
