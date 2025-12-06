<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Tutor;
use App\Models\Estudiante;
use App\Models\Periodo;
use App\Models\Grupo;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with('grupo')->get();
        return view('asistencias.index', compact('asistencias'));
    }

    public function create()
    {
        $grupos = Grupo::with(['estudiantes' => function($query){
            $query->where('estado', 'activo'); // Solo estudiantes activos
        }])->get();

        return view('asistencias.create', compact('grupos'));
    }

    // Método AJAX para obtener estudiantes de un grupo
    public function estudiantesPorGrupo($grupo_id)
    {
        $grupo = Grupo::with('estudiantes')->findOrFail($grupo_id);
        return response()->json($grupo->estudiantes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutores_id' => 'required|exists:tutores,id',
            'estudiantes_id' => 'required|exists:estudiantes,id',
            'periodo_id' => 'required|exists:periodo,id',
            'sesion' => 'required|integer|min:1',
            'fecha' => 'required|date',
            'estado' => 'required|in:si,no,np,justificado',
        ]);

        Asistencia::create($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente');
    }

        public function edit($id)
    {
            $asistencia = Asistencia::findOrFail($id);

        $grupos = Grupo::with(['estudiantes' => function($query){
            $query->where('estado', 'activo');
        }])->get();

        // Solo estudiantes activos del grupo de la asistencia
        $estudiantes = $asistencia->grupo->estudiantes->where('estado', 'activo');
        return view('asistencias.edit', compact('asistencia', 'grupos', 'estudiantes'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tutores_id' => 'required|exists:tutores,id',
            'estudiantes_id' => 'required|exists:estudiantes,id',
            'periodo_id' => 'required|exists:periodo,id',
            'sesion' => 'required|integer|min:1',
            'fecha' => 'required|date',
            'estado' => 'required|in:si,no,np,justificado',
        ]);

        $asistencia = Asistencia::findOrFail($id);
        $asistencia->update($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente');
    }

    public function destroy($id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->delete();

        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada');
    }
}
