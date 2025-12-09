<?php

namespace App\Http\Controllers;

use App\Models\PAT;
use App\Models\Tutor;
use App\Models\Grupo;
use App\Models\Periodo;
use Illuminate\Http\Request;

class PATController extends Controller
{
    public function index(Request $request)
    {
     
        $grupos = Grupo::all();
        $periodos = Periodo::all();
      
        $query = PAT::with(['tutor', 'grupo', 'periodo'])
            ->orderBy('created_at', 'desc');
        
        if ($request->filled('grupo_id')) {
            $query->where('grupos_id', $request->grupo_id);
        }
       
        if ($request->filled('periodo_id')) {
            $query->where('periodo_id', $request->periodo_id);
        }
        $pats = $query->get();

        return view('pats.index', compact('pats', 'grupos', 'periodos'));
    }

public function dashboard(Request $request)
    {
        $grupos = Grupo::all();
        $periodos = Periodo::all();
       
        if ($request->filled('grupo_id')) {
            $grupos = $grupos->where('id', $request->grupo_id);
        }
        
        $queryEstadisticas = PAT::query();
        
        if ($request->filled('periodo_id')) {
            $queryEstadisticas->where('periodo_id', $request->periodo_id);
        }
        
        $total = $queryEstadisticas->count();
        $completados = $queryEstadisticas->where('estado', 'completado')->count();
        $enProceso = $queryEstadisticas->where('estado', 'en_proceso')->count();
        $pendientes = $queryEstadisticas->where('estado', 'pendiente')->count();
        
        $estadisticas = [
            'total' => $total,
            'completados' => $completados,
            'en_proceso' => $enProceso,
            'pendientes' => $pendientes,
            'porcentaje_completados' => $total > 0 ? ($completados / $total) * 100 : 0,
            'porcentaje_en_proceso' => $total > 0 ? ($enProceso / $total) * 100 : 0,
            'porcentaje_pendientes' => $total > 0 ? ($pendientes / $total) * 100 : 0,
        ];
        
        return view('pats.dashboard', compact('grupos', 'periodos', 'estadisticas'));
    }

    public function create(Request $request)
    {
        $tutores = Tutor::all();
        $grupos = Grupo::all();
        $periodos = Periodo::all();
     
        $grupoPreSeleccionado = $request->get('grupo_id');
        
        return view('pats.create', compact('tutores', 'grupos', 'periodos', 'grupoPreSeleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutores_id' => 'required|exists:tutores,id',
            'grupos_id' => 'required|exists:grupos,id',
            'periodo_id' => 'required|exists:periodo,id',
            'actividades' => 'required|array|min:1',
        ]);

        try {
            foreach ($request->actividades as $actividadData) {
             
                $existente = PAT::where('grupos_id', $request->grupos_id)
                    ->where('tutores_id', $request->tutores_id)
                    ->where('periodo_id', $request->periodo_id)
                    ->where('actividad', $actividadData['actividad'])
                    ->first();
                
                if ($existente) {
                    continue;
                }
                
                $semanasPlaneadas = [];
                $semanasReales = [];
                
                if (isset($actividadData['planeada'])) {
                    $semanasPlaneadas[] = 'P';
                }
             
                if (isset($actividadData['semanas'])) {
                    foreach ($actividadData['semanas'] as $semana => $marcado) {
                        if ($marcado) {
                            $semanasReales[] = $semana;
                        }
                    }
                }
           
                $estado = 'pendiente';
                if (count($semanasReales) > 0) {
                    $estado = count($semanasReales) == 16 ? 'completado' : 'en_proceso';
                }
                
                PAT::create([
                    'tutores_id' => $request->tutores_id,
                    'grupos_id' => $request->grupos_id,
                    'periodo_id' => $request->periodo_id,
                    'actividad' => $actividadData['actividad'],
                    'responsable' => $actividadData['responsable'],
                    'semana_planeada' => implode(',', $semanasPlaneadas),
                    'semana_real' => implode(',', $semanasReales),
                    'estado' => $estado,
                ]);
            }

            return redirect()->route('pats.index', ['grupo_id' => $request->grupos_id])
                ->with('success', 'PAT registrado exitosamente para el grupo.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar el PAT: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
{
    $pat = PAT::findOrFail($id);
    $tutores = Tutor::all();
    $grupos = Grupo::all();
    $periodos = Periodo::all();
    
    return view('pats.edit', compact('pat', 'tutores', 'grupos', 'periodos'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'tutores_id' => 'required|exists:tutores,id',
        'grupos_id' => 'required|exists:grupos,id',
        'periodo_id' => 'required|exists:periodo,id',
        'actividad' => 'required|string|max:150',
        'responsable' => 'required|in:tutor,tutorado',
        'estado' => 'required|in:pendiente,en_proceso,completado',
    ]);

    try {
        $pat = PAT::findOrFail($id);
        
        $semanasPlaneadas = [];
        if ($request->has('planeada')) {
            $semanasPlaneadas[] = 'P';
        }
  
        $semanasReales = [];
        if ($request->has('semanas')) {
            foreach ($request->semanas as $semana => $marcado) {
                if ($marcado) {
                    $semanasReales[] = $semana;
                }
            }
        }
    
        $pat->update([
            'tutores_id' => $request->tutores_id,
            'grupos_id' => $request->grupos_id,
            'periodo_id' => $request->periodo_id,
            'actividad' => $request->actividad,
            'responsable' => $request->responsable,
            'semana_planeada' => implode(',', $semanasPlaneadas),
            'semana_real' => implode(',', $semanasReales),
            'estado' => $request->estado,
        ]);
    
        if ($request->has('nueva_actividad') && !empty($request->nueva_actividad)) {
            $nuevasSemanasReales = [];
            if ($request->has('nueva_semanas')) {
                foreach ($request->nueva_semanas as $semana => $marcado) {
                    if ($marcado) {
                        $nuevasSemanasReales[] = $semana;
                    }
                }
            }
            
            $nuevoEstado = count($nuevasSemanasReales) > 0 ? 
                          (count($nuevasSemanasReales) == 16 ? 'completado' : 'en_proceso') : 
                          'pendiente';
            
            PAT::create([
                'tutores_id' => $request->tutores_id,
                'grupos_id' => $request->grupos_id,
                'periodo_id' => $request->periodo_id,
                'actividad' => $request->nueva_actividad,
                'responsable' => $request->nueva_responsable ?? 'tutor',
                'semana_planeada' => $request->has('nueva_planeada') ? 'P' : '',
                'semana_real' => implode(',', $nuevasSemanasReales),
                'estado' => $nuevoEstado,
            ]);
        }

        return redirect()->route('pats.index')
            ->with('success', 'PAT actualizado exitosamente.');
            
    } catch (\Exception $e) {
        return back()->with('error', 'Error al actualizar el PAT: ' . $e->getMessage());
    }
}
public function destroy($id)
{
    try {
        $pat = PAT::findOrFail($id);
        $pat->delete();

        return redirect()->route('pats.index')
            ->with('success', 'PAT eliminado exitosamente.');
            
    } catch (\Exception $e) {
        return redirect()->route('pats.index')
            ->with('error', 'Error al eliminar el PAT: ' . $e->getMessage());
    }
}

}