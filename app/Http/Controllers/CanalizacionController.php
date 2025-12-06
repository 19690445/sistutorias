<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Canalizacion;
use App\Models\Individual;
use Illuminate\Support\Facades\Auth;

class CanalizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin') || $user->hasRole('coordinador')) {
            
            $canalizaciones = Canalizacion::with('individuale.estudiante')->get();
        } else { // docente
           
            $canalizaciones = Canalizacion::whereHas('individuale', function($q) use ($user) {
                $q->where('tutores_id', $user->id)
                ->where('requiere_canalizacion', 'si');
            })->with('individuale.estudiante')->get();
        }

        return view('canalizaciones.index', compact('canalizaciones'));
        }


    public function create()
    {
    
        $individuales = Individual::with('estudiante')
            ->where('requiere_canalizacion', 'si')
            ->get();

        return view('canalizaciones.create', compact('individuales'));
        }


    public function store(Request $request)
    {
        $request->validate([
            'individuales_id' => 'required|exists:individuales,id',
            'tipo_atencion' => 'required',
            'causa_problema' => 'nullable',
            'acciones_sugeridas' => 'nullable',
            'primera_sesion_propuesta' => 'nullable|date',
        ]);

        Canalizacion::create($request->all());

        return redirect()->route('canalizaciones.index')->with('success', 'Canalización creada correctamente');
    }

    public function show($id)
    {
        $canalizacion = Canalizacion::with('individuale.estudiante')->findOrFail($id);
        return view('canalizaciones.show', compact('canalizacion'));
    }

    public function edit($id)
    {
        $canalizacion = Canalizacion::findOrFail($id);
        $individuales = Individual::where('requiere_canalizacion', 'si')->get();
        return view('canalizaciones.edit', compact('canalizacion', 'individuales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_atencion' => 'required',
            'causa_problema' => 'nullable',
            'acciones_sugeridas' => 'nullable',
            'primera_sesion_propuesta' => 'nullable|date',
            'primera_sesion_real' => 'nullable|date',
            'seguimiento_tutor' => 'nullable',
            'estado' => 'nullable|in:pendiente,en_proceso,finalizado',
            'observaciones' => 'nullable',
        ]);

        $canalizacion = Canalizacion::findOrFail($id);
        $canalizacion->update($request->all());

        return redirect()->route('canalizaciones.index')->with('success', 'Canalización actualizada correctamente');
    }

    
    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user->hasRole('admin')) {
            abort(403);
        }

        $canalizacion = Canalizacion::findOrFail($id);
        $canalizacion->delete();

        return redirect()->route('canalizaciones.index')->with('success', 'Canalización eliminada correctamente');
    }
}
