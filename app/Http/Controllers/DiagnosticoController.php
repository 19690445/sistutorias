<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Indicador;
use App\Models\Grupo;
use App\Models\Periodo;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function index(Request $request)
    {
        $grupos = Grupo::all();
        $periodos = Periodo::all();
        
        $query = Diagnostico::with(['grupo', 'periodo', 'indicadores'])
            ->orderBy('created_at', 'desc');
        
        if ($request->filled('grupo_id')) {
            $query->where('grupos_id', $request->grupo_id);
        }
        
        if ($request->filled('periodo_id')) {
            $query->where('periodo_id', $request->periodo_id);
        }
        
        $diagnosticos = $query->paginate(10);
        
        return view('diagnosticos.index', compact('diagnosticos', 'grupos', 'periodos'));
    }

    public function create()
    {
        $grupos = Grupo::all();
        $periodos = Periodo::all();
        
        return view('diagnosticos.create', compact('grupos', 'periodos'));
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'grupos_id' => 'required|exists:grupos,id',
            'periodo_id' => 'required|exists:periodo,id',
            'problemarios' => 'nullable|string',
            'solucion' => 'nullable|string',
            'objetivos' => 'nullable|string',
            'fecha_realizacion' => 'nullable|date',
            'estado' => 'required|in:pendiente,en_proceso,completado',
            'observaciones' => 'nullable|string',
        ]);

        try {
          
            $diagnostico = Diagnostico::create([
                'grupos_id' => $request->grupos_id,
                'periodo_id' => $request->periodo_id,
                'problemarios' => $request->problemarios,
                'solucion' => $request->solucion,
                'objetivos' => $request->objetivos,
                'fecha_realizacion' => $request->fecha_realizacion,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
            ]);

         
            if ($request->has('indicadores') && is_array($request->indicadores)) {
                foreach ($request->indicadores as $indicadorData) {
                
                    $nombreIndicador = $indicadorData['indicador'] ?? '';
                
                    if ($nombreIndicador === 'OTRO') {
                        $nombreIndicador = $indicadorData['indicador_otro'] ?? '';
                    }
           
                    if (!empty($nombreIndicador)) {
                       
                        $tienePresencia = isset($indicadorData['presencia']) && $indicadorData['presencia'] == '1';
                        
                        
                        Indicador::create([
                            'diagnosticos_id' => $diagnostico->id,
                            'causa' => $indicadorData['causa'] ?? null,
                            'clave_indicadora' => 'IND-' . strtoupper(substr(md5($nombreIndicador), 0, 6)),
                            'descripcion' => $nombreIndicador,
                            'meta' => 'Resolver la problemática',
                            'fecha_registro' => now(),
                            'estado' => $tienePresencia ? 'pendiente' : 'no_aplica',
                            'notas' => $tienePresencia ? 'Indicador con presencia SI' : 'Indicador sin presencia',
                        ]);
                    }
                }
            }

            return redirect()->route('diagnosticos.index')
                ->with('success', 'Diagnóstico creado exitosamente.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el diagnóstico: ' . $e->getMessage())
                        ->withInput();
        }
    }

    public function edit($id)
    {
        $diagnostico = Diagnostico::with('indicadores')->findOrFail($id);
        $grupos = Grupo::all();
        $periodos = Periodo::all();
        
        return view('diagnosticos.edit', compact('diagnostico', 'grupos', 'periodos'));
    }

   public function update(Request $request, $id)
    {
      
        $request->validate([
            'grupos_id' => 'required|exists:grupos,id',
            'periodo_id' => 'required|exists:periodo,id',
            'problemarios' => 'nullable|string',
            'solucion' => 'nullable|string',
            'objetivos' => 'nullable|string',
            'fecha_realizacion' => 'nullable|date',
            'estado' => 'required|in:pendiente,en_proceso,completado',
            'observaciones' => 'nullable|string',
            'indicadores' => 'nullable|array',
            'indicadores.*.id' => 'nullable|exists:indicadores,id',
            'indicadores.*.indicador' => 'required_with:indicadores|string',
            'indicadores.*.indicador_otro' => 'nullable|string',
            'indicadores.*.presencia' => 'nullable|in:0,1',
            'indicadores.*.causa' => 'nullable|string',
        ]);

        try {
            
            \DB::beginTransaction();
            
          
            $diagnostico = Diagnostico::with('indicadores')->findOrFail($id);
            
            $diagnostico->update([
                'grupos_id' => $request->grupos_id,
                'periodo_id' => $request->periodo_id,
                'problemarios' => $request->problemarios,
                'solucion' => $request->solucion,
                'objetivos' => $request->objetivos,
                'fecha_realizacion' => $request->fecha_realizacion,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
            ]);

            
            if ($request->has('indicadores') && is_array($request->indicadores)) {
                $indicadoresIds = [];
                
                foreach ($request->indicadores as $indicadorData) {
                  
                    $nombreIndicador = $indicadorData['indicador'];
                    if ($nombreIndicador === 'OTRO' && isset($indicadorData['indicador_otro'])) {
                        $nombreIndicador = $indicadorData['indicador_otro'];
                    }
                    
                   
                    $tienePresencia = isset($indicadorData['presencia']) && $indicadorData['presencia'] == '1';
                    
                   
                    if (isset($indicadorData['id']) && !empty($indicadorData['id'])) {
                        $indicador = Indicador::find($indicadorData['id']);
                        
                        if ($indicador) {
                            $indicador->update([
                                'descripcion' => $nombreIndicador,
                                'causa' => $indicadorData['causa'] ?? null,
                                'estado' => $tienePresencia ? 'pendiente' : 'no_aplica',
                                'notas' => $tienePresencia ? 'Indicador con presencia SI' : 'Indicador sin presencia',
                            ]);
                            
                            $indicadoresIds[] = $indicador->id;
                        }
                    } else {
                      
                        $nuevoIndicador = Indicador::create([
                            'diagnosticos_id' => $diagnostico->id,
                            'descripcion' => $nombreIndicador,
                            'causa' => $indicadorData['causa'] ?? null,
                            'clave_indicadora' => 'IND-' . strtoupper(substr(md5($nombreIndicador), 0, 6)),
                            'meta' => 'Resolver la problemática',
                            'fecha_registro' => now(),
                            'estado' => $tienePresencia ? 'pendiente' : 'no_aplica',
                            'notas' => $tienePresencia ? 'Indicador con presencia SI' : 'Indicador sin presencia',
                        ]);
                        
                        $indicadoresIds[] = $nuevoIndicador->id;
                    }
                }
                
                
                if (!empty($indicadoresIds)) {
                    $diagnostico->indicadores()
                        ->whereNotIn('id', $indicadoresIds)
                        ->delete();
                }
            } else {
               
                $diagnostico->indicadores()->delete();
            }

          
            \DB::commit();

            return redirect()->route('diagnosticos.index')
                ->with('success', 'Diagnóstico actualizado exitosamente.');
                
        } catch (\Exception $e) {
            
            \DB::rollBack();
            
            return back()->with('error', 'Error al actualizar el diagnóstico: ' . $e->getMessage())
                        ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $diagnostico = Diagnostico::findOrFail($id);
            $diagnostico->delete();

            return redirect()->route('diagnosticos.index')
                ->with('success', 'Diagnóstico eliminado exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->route('diagnosticos.index')
                ->with('error', 'Error al eliminar el diagnóstico: ' . $e->getMessage());
        }
    }

}