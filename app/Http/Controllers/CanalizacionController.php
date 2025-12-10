<?php

namespace App\Http\Controllers;

use App\Models\Canalizacion;
use App\Models\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class CanalizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('tutorado')) {
           
            $estudiante = $user->estudiante;
            
            if (!$estudiante) {
                return redirect()->back()->with('error', 'No se encontró información del estudiante');
            }
            
            $canalizaciones = Canalizacion::whereHas('individual', function($query) use ($estudiante) {
                $query->where('estudiante_id', $estudiante->id);
            })
            ->with(['individual.estudiante', 'individual.tutor', 'individual.periodo'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        } else {
            
            $canalizaciones = Canalizacion::with(['individual.estudiante', 'individual.tutor', 'individual.periodo'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        
        return view('canalizaciones.index', compact('canalizaciones'));
    }

    public function create()
    {
        $individualSeleccionado = null;
        
        
        if (request()->has('individual_id')) {
            $individualSeleccionado = Individual::with(['estudiante', 'tutor', 'periodo'])
                ->find(request('individual_id'));
        }

        // Solo obtener individuales sin canalizaciones si no hay individual seleccionado
        $individuales = Individual::whereDoesntHave('canalizaciones')->get();
        
        return view('canalizaciones.create', compact('individuales', 'individualSeleccionado'));
    }
  
    public function store(Request $request)
    {
        $user = Auth::user();
        
        
        if ($user->hasRole('tutorado')) {
            abort(403, 'No tienes permiso para crear canalizaciones');
        }
        
        $request->validate([
            'individuales_id' => 'required|exists:individuales,id',
            'tipo_atencion' => 'required|string|max:255',
            'causa_problema' => 'nullable|string',
            'causa_problema_general' => 'nullable|string',
            'acciones_sugeridas' => 'required|string',
            'primera_sesion_propuesta' => 'nullable|date',
            'primera_sesion_real' => 'nullable|date',
            'seguimiento_tutor' => 'nullable|string',
            'estado' => 'required|in:pendiente,en_proceso,finalizado',
            'observaciones' => 'nullable|string',
        ]);
        
        Canalizacion::create($request->all());
        
        return redirect()->route('canalizaciones.index')
            ->with('success', 'Canalización creada exitosamente');
    }


    public function show(Canalizacion $canalizacione)
    {
        $user = Auth::user();
        
    
        if ($user->hasRole('tutorado')) {
           
            $estudiante = $user->estudiante;
            if (!$estudiante) {
                abort(403, 'No se encontró información del estudiante');
            }
            
            $canalizacionEstudianteId = $canalizacione->individual->estudiante_id ?? null;
            
            if ($estudiante->id !== $canalizacionEstudianteId) {
                abort(403, 'No tienes permiso para ver esta canalización');
            }
        }
        
     
        $canalizacione->load([
            'individual' => function($query) {
                $query->with(['estudiante', 'tutor', 'periodo']);
            }
        ]);
        
        return view('canalizaciones.show', compact('canalizacione'));
    }

 
    public function edit(Canalizacion $canalizacione)
    {
        $user = Auth::user();
        
       
        if ($user->hasRole('tutorado')) {
            abort(403, 'No tienes permiso para editar canalizaciones');
        }
        
     
        $canalizacione->load([
            'individual' => function($query) {
                $query->with(['estudiante', 'tutor', 'periodo']);
            }
        ]);
        
        return view('canalizaciones.edit', compact('canalizacione'));
    }

    
    public function update(Request $request, Canalizacion $canalizacione)
    {
        $user = Auth::user();
        
      
        if ($user->hasRole('tutorado')) {
            abort(403, 'No tienes permiso para editar canalizaciones');
        }
        
        $request->validate([
            'tipo_atencion' => 'required|string|max:255',
            'causa_problema' => 'nullable|string',
            'causa_problema_general' => 'nullable|string',
            'acciones_sugeridas' => 'required|string',
            'primera_sesion_propuesta' => 'nullable|date',
            'primera_sesion_real' => 'nullable|date',
            'seguimiento_tutor' => 'nullable|string',
            'estado' => 'required|in:pendiente,en_proceso,finalizado',
            'observaciones' => 'nullable|string',
        ]);
        
        $canalizacione->update($request->all());
        
        return redirect()->route('canalizaciones.show', $canalizacione)
            ->with('success', 'Canalización actualizada exitosamente');
    }

    
    public function destroy(Canalizacion $canalizacione)
    {
        $user = Auth::user();
        
        if ($user->hasRole('tutorado')) {
            abort(403, 'No tienes permiso para eliminar canalizaciones');
        }
        
        $canalizacione->delete();
        
        return redirect()->route('canalizaciones.index')
            ->with('success', 'Canalización eliminada exitosamente');
    }
}