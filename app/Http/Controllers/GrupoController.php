<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Tutor;
use App\Models\Periodo;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrupoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'docente') {
            $grupos = Grupo::where('tutores_id', $user->tutor_id)
                            ->with('tutor', 'periodo', 'estudiantes')
                            ->get();
        } else {
            $grupos = Grupo::with('tutor', 'periodo', 'estudiantes')->get();
        }

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $tutores = Tutor::all();
        $periodos = Periodo::all();

        return view('grupos.create', compact('tutores', 'periodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave_grupo' => 'required|unique:grupos',
            'nombre_grupo' => 'required',
            'tutores_id' => 'required',
            'periodo_id' => 'required',
            'carrera' => 'required',
            'semestre' => 'required',
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.index')->with('success', 'Grupo creado correctamente');
    }

    public function show($id)
    {
        $grupo = Grupo::with('estudiantes')->findOrFail($id);
        return view('grupos.show', compact('grupo'));
    }

    public function edit($id)
    {
        $grupo = Grupo::findOrFail($id);
        $tutores = Tutor::all();
        $periodos = Periodo::all();

        return view('grupos.edit', compact('grupo', 'tutores', 'periodos'));
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->update($request->all());

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado correctamente');
    }

    public function destroy($id)
    {
        Grupo::destroy($id);
        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado correctamente');
    }

    public function addStudents($id)
    {
        $grupo = Grupo::findOrFail($id);
        $estudiantes = Estudiante::where('grupo_id', null)->get();

        return view('grupos.add-students', compact('grupo', 'estudiantes'));
    }

    public function storeStudents(Request $request, $id)
    {
        foreach ($request->estudiantes as $alumnoId) {
            $estudiante = Estudiante::find($alumnoId);
            $estudiante->grupo_id = $id;
            $estudiante->save();
        }

        return redirect()->route('grupos.show', $id)->with('success', 'Estudiantes agregados');
    }
}
