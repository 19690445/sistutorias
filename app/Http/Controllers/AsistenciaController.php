<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\Periodo;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    public function index(Request $request)
{
    $query = Asistencia::with(['tutor', 'estudiante', 'grupo', 'periodo']);
    
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('tutor', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%");
            })
            ->orWhereHas('estudiante', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('matricula', 'like', "%{$search}%");
            })
            ->orWhereHas('grupo', function($q) use ($search) {
                $q->where('nombre_grupo', 'like', "%{$search}%")
                  ->orWhere('clave_grupo', 'like', "%{$search}%");
            });
        });
    }
    
  
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }
    
   
    if ($request->filled('grupo_id')) {
        $query->where('grupo_id', $request->grupo_id);
    }
    
    
    if ($request->filled('tutor_id')) {
        $query->where('tutores_id', $request->tutor_id);
    }
    
    
    if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
        $query->whereBetween('fecha', [
            $request->fecha_desde,
            $request->fecha_hasta
        ]);
    } elseif ($request->filled('fecha_desde')) {
        $query->where('fecha', '>=', $request->fecha_desde);
    } elseif ($request->filled('fecha_hasta')) {
        $query->where('fecha', '<=', $request->fecha_hasta);
    }
    
    
    $grupos = Grupo::orderBy('nombre_grupo')->get();
    $tutores = Tutor::orderBy('nombre')->get();
    
   
    $totalAsistencias = Asistencia::count();
    $presentes = Asistencia::where('estado', 'si')->count();
    $ausentes = Asistencia::where('estado', 'no')->count();
    $porcentajeAsistencia = $totalAsistencias > 0 ? round(($presentes / $totalAsistencias) * 100, 1) : 0;
    
    
    $asistencias = $query->orderBy('fecha', 'desc')
                        ->orderBy('sesion', 'desc')
                        ->paginate(20)
                        ->withQueryString();
    
    return view('asistencias.index', compact(
        'asistencias',
        'grupos',
        'tutores',
        'totalAsistencias',
        'presentes',
        'ausentes',
        'porcentajeAsistencia'
    ));
}

    public function create()
    {
        $tutores = Tutor::all();
        $periodos = Periodo::all();
        $grupos = Grupo::all();
        
        return view('asistencias.create', compact('tutores', 'periodos', 'grupos'));
    }
            
    public function malla($grupoId)
    {
        $grupo = Grupo::findOrFail($grupoId);
        $estudiantes = Estudiante::where('grupo_id', $grupoId)
            ->orderBy('nombre')
            ->get();
        $periodos = Periodo::all();
        $tutores = Tutor::all();
        
        return view('asistencias.malla', compact('grupo', 'estudiantes', 'periodos', 'tutores'));
    }

    public function getEstudiantesByGrupo($grupoId)
    {
        $estudiantes = Estudiante::where('grupo_id', $grupoId)
            ->orderBy('nombre')
            ->get()
            ->map(function($estudiante) {
                return [
                    'id' => $estudiante->id,
                    'nombre_completo' => $estudiante->nombre . ' ' . $estudiante->apellido,
                ];
            });
        
        return response()->json($estudiantes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutores_id' => 'required|exists:tutores,id',
            'grupo_id' => 'required|exists:grupos,id',
            'periodo_id' => 'required|exists:periodo,id',
            'sesion' => 'required|integer|min:1',
            'fecha' => 'required|date',
            'estudiantes' => 'required|array',
            'estudiantes.*.estado' => 'required|in:si,no,np,justificado',
            'estudiantes.*.observaciones' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        
        try {
         
            $existe = Asistencia::where('grupo_id', $request->grupo_id)
                ->where('periodo_id', $request->periodo_id)
                ->where('sesion', $request->sesion)
                ->where('fecha', $request->fecha)
                ->exists();
            
            if ($existe) {
                return back()->with('error', 'Ya existe registro de asistencia para esta sesión y fecha.');
            }
            
            
            foreach ($request->estudiantes as $estudianteData) {
                Asistencia::create([
                    'tutores_id' => $request->tutores_id,
                    'estudiantes_id' => $estudianteData['id'],
                    'grupo_id' => $request->grupo_id,
                    'periodo_id' => $request->periodo_id,
                    'sesion' => $request->sesion,
                    'fecha' => $request->fecha,
                    'estado' => $estudianteData['estado'],
                    'observaciones' => $estudianteData['observaciones'] ?? null,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('asistencias.index')
                ->with('success', 'Asistencias registradas correctamente para ' . count($request->estudiantes) . ' estudiantes.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al registrar asistencias: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $asistencia = Asistencia::with(['estudiante'])->findOrFail($id);
        $tutores = Tutor::all();
        $periodos = Periodo::all();
        $grupos = Grupo::all();
        
        return view('asistencias.edit', compact('asistencia', 'tutores', 'periodos', 'grupos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:si,no,np,justificado',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $asistencia = Asistencia::findOrFail($id);
        $asistencia->update($request->only(['estado', 'observaciones']));

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->delete();

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia eliminada correctamente.');
    }

    public function reporte()
    {
        $grupos = Grupo::all();
        $periodos = Periodo::all();
        
        return view('asistencias.reporte', compact('grupos', 'periodos'));
    }

    public function historial($estudianteId)
    {
        $estudiante = Estudiante::with(['asistencias' => function($query) {
            $query->orderBy('fecha', 'desc')
                  ->orderBy('sesion', 'desc');
        }, 'asistencias.tutor', 'asistencias.periodo', 'asistencias.grupo'])
        ->findOrFail($estudianteId);

        return view('asistencias.partials.historial', compact('estudiante'));
    }

    public function generarReporte(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'periodo_id' => 'required|exists:periodo,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $asistencias = Asistencia::with(['estudiante'])
            ->where('grupo_id', $request->grupo_id)
            ->where('periodo_id', $request->periodo_id)
            ->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->orderBy('estudiantes_id')
            ->orderBy('fecha')
            ->get();

        $reporte = [];
        foreach ($asistencias as $asistencia) {
            $estudianteId = $asistencia->estudiantes_id;
            
            if (!isset($reporte[$estudianteId])) {
                $reporte[$estudianteId] = [
                    'estudiante' => $asistencia->estudiante,
                    'total_sesiones' => 0,
                    'presentes' => 0,
                    'ausentes' => 0,
                    'justificados' => 0,
                    'no_programados' => 0,
                    'asistencias' => []
                ];
            }
            
            $reporte[$estudianteId]['total_sesiones']++;
            $reporte[$estudianteId]['asistencias'][] = $asistencia;
            
            switch ($asistencia->estado) {
                case 'si':
                    $reporte[$estudianteId]['presentes']++;
                    break;
                case 'no':
                    $reporte[$estudianteId]['ausentes']++;
                    break;
                case 'justificado':
                    $reporte[$estudianteId]['justificados']++;
                    break;
                case 'np':
                    $reporte[$estudianteId]['no_programados']++;
                    break;
            }
        }

        return view('asistencias.resultado-reporte', compact('reporte', 'request'));
    }
}