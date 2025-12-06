<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Grupo;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        if ($user->role->nombre === 'coordinador') {
            $diagnosticos = Diagnostico::with(['grupo', 'periodo'])->latest()->get();
        } 
        
        elseif ($user->role->nombre === 'docente') {
            $gruposIds = Grupo::where('tutores_id', $user->tutor->id ?? null)->pluck('id');
            $diagnosticos = Diagnostico::whereIn('grupos_id', $gruposIds)
                ->with(['grupo', 'periodo'])->get();
        } 
        
        else {
            $grupoId = $user->estudiante->grupo_id ?? null;
            $diagnosticos = Diagnostico::where('grupos_id', $grupoId)
                ->with(['grupo', 'periodo'])->get();
        }

        return view('diagnosticos.index', compact('diagnosticos'));
    }

   
    public function create()
    {
        $this->authorize('create', Diagnostico::class);
        $grupos = Grupo::all();
        return view('diagnosticos.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Diagnostico::class);

        $request->validate([
            'grupos_id' => 'required|exists:grupos,id',
            'periodo_id' => 'required|exists:periodo,id',
            'problemarios' => 'required|string',
            'objetivos' => 'required|string',
            'fecha_realizacion' => 'required|date'
        ]);

        Diagnostico::create($request->all());

        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico creado correctamente.');
    }

    public function responder(Request $request, Diagnostico $diagnostico)
    {
        $this->authorize('update', $diagnostico);

        $request->validate([
            'solucion' => 'required|string',
        ]);

        $diagnostico->update([
            'solucion' => $request->solucion,
            'estado' => 'en_proceso',
        ]);

        return back()->with('success', 'Has contestado el diagnóstico.');
    }

    public function show(Diagnostico $diagnostico)
    {
        $diagnostico->load(['grupo', 'periodo']);
        return view('diagnosticos.show', compact('diagnostico'));
    }
}
