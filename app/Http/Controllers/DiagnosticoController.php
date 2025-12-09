<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Grupo;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticoController extends Controller
{
    public function __construct()
    {
        
        $this->middleware(['auth', 'role:admin,coordinador,docente']);
    }

    public function index()
{
    $user = Auth::user();

    
    if (in_array($user->role->nombre, ['admin', 'coordinador'])) {
        $diagnosticos = Diagnostico::with(['grupo', 'periodo'])->latest()->get();
    }
    
    elseif ($user->role->nombre === 'docente') {
        $tutorId = $user->tutor->id ?? null;

        if ($tutorId) {
           
            $gruposIds = Grupo::where('tutores_id', $tutorId)->pluck('id')->toArray();
        } else {
          
            $gruposIds = Grupo::pluck('id')->toArray();
        }

        $diagnosticos = Diagnostico::whereIn('grupos_id', $gruposIds)
            ->with(['grupo', 'periodo'])
            ->latest()
            ->get();
    }
    
    else {
        $grupoId = $user->estudiante->grupo_id ?? null;

        if ($grupoId) {
            $diagnosticos = Diagnostico::where('grupos_id', $grupoId)
                ->with(['grupo', 'periodo'])
                ->latest()
                ->get();
        } else {
            $diagnosticos = collect(); 
        }
    }

    return view('diagnosticos.index', compact('diagnosticos'));
}

    public function create()
    {
        $this->authorize('create', Diagnostico::class);
        $grupos = Grupo::all();
        $periodos = Periodo::all();
        return view('diagnosticos.create', compact('grupos', 'periodos'));
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

        return redirect()->route('diagnosticos.index')
            ->with('success', 'Diagnóstico creado correctamente.');
    }

    public function show(Diagnostico $diagnostico)
    {
        $diagnostico->load(['grupo', 'periodo']);
        return view('diagnosticos.show', compact('diagnostico'));
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
}
