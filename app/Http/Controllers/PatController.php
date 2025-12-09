<?php

namespace App\Http\Controllers;

use App\Models\Pat;
use App\Models\Tutor;
use App\Models\Grupo;
use App\Models\Periodo;
use Illuminate\Http\Request;

class PatController extends Controller
{
    public function index()
    {
        $pats = Pat::with('tutor', 'grupo', 'periodo')->get();
        return view('pats.index', compact('pats'));
    }

    public function create()
    {
        $tutores = Tutor::orderBy('nombre')->get();
        $grupos = Grupo::orderBy('nombre_grupo')->get();
        $periodos = Periodo::orderBy('nombre_periodo')->get();

        return view('pats.create', compact('tutores', 'grupos', 'periodos'));
    }


    public function store(Request $request)
    {
        // Validación de campos
        $request->validate([
            'actividad' => 'required|string|max:150',
            'tutores_id' => 'required|exists:tutores,id',
            'grupos_id' => 'required|exists:grupos,id',
            'responsable' => 'nullable|string|max:100',
            'semana_planeada' => 'nullable|string|max:50',
            'semana_real' => 'nullable|string|max:50',
            'estado' => 'nullable|in:pendiente,en_proceso,completado',
        ]);

        // Guardar en base de datos
        Pat::create([
            'actividad' => $request->actividad,
            'tutores_id' => $request->tutores_id,
            'grupos_id' => $request->grupos_id,
            'responsable' => $request->responsable,
            'semana_planeada' => $request->semana_planeada,
            'semana_real' => $request->semana_real,
            'estado' => $request->estado ?? 'pendiente',
        ]);

        return redirect()->route('pats.index')->with('success', 'PAT registrado correctamente');
   
    }

}
