<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Tutor;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rules\File;

class GrupoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->rol_id == 3) {
        
            $grupos = Grupo::whereHas('tutor', function($query) use ($user) {
                $query->where('users_id', $user->id);
            })->get();
        } else {
           
            $grupos = Grupo::all();
        }

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!in_array($user->rol_id, [1,2])) {
            abort(403, 'No tienes permiso para crear grupos.');
        }

        $tutores = Tutor::all();
        $periodos = Periodo::all();
        return view('grupos.create', compact('tutores', 'periodos'));
    }

    
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->rol_id, [1,2])) {
            abort(403, 'No tienes permiso para crear grupos.');
        }

        $request->validate([
            'clave_grupo' => 'required|string|max:20|unique:grupos,clave_grupo',
            'nombre_grupo' => 'required|string|max:100',
            'tutores_id' => 'required|exists:tutores,id',
            'periodo_id' => 'required|exists:periodo,id',
            'carrera' => 'required|string|max:100',
            'semestre' => 'required|integer',
            'modalidad' => 'required|in:presencial,virtual,mixta',
            'turno' => 'required|in:matutino,intermedio,vespertino',
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo creado correctamente');
    }


    public function edit($id)
    {
        $grupo = Grupo::findOrFail($id);
        $this->authorizeGrupo($grupo, 'editar');

        $tutores = Tutor::all();
        $periodos = Periodo::all();
        return view('grupos.edit', compact('grupo', 'tutores', 'periodos'));
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);
        $this->authorizeGrupo($grupo, 'editar');

        $request->validate([
            'clave_grupo' => 'required|string|max:20|unique:grupos,clave_grupo,' . $id,
            'nombre_grupo' => 'required|string|max:100',
            'tutores_id' => 'required|exists:tutores,id',
            'periodo_id' => 'required|exists:periodo,id',
            'carrera' => 'required|string|max:100',
            'semestre' => 'required|integer',
            'modalidad' => 'required|in:presencial,virtual,mixta',
            'turno' => 'required|in:matutino,intermedio,vespertino',
        ]);

        $grupo->update($request->all());

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $this->authorizeGrupo($grupo, 'eliminar');

        $grupo->delete();

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo eliminado correctamente.');
    }

    public function show($id)
    {
        $grupo = Grupo::with('estudiantes')->findOrFail($id);
        $this->authorizeGrupo($grupo, 'ver');

        return view('grupos.show', compact('grupo'));
    }

    public function formImportar($grupoId)
    {
        $grupo = Grupo::findOrFail($grupoId);
        $this->authorizeGrupo($grupo, 'editar');

        return view('grupos.importar', compact('grupo'));
    }

    
    public function importarExcel(Request $request, $grupoId)
    {
        $grupo = Grupo::findOrFail($grupoId);
        $this->authorizeGrupo($grupo, 'editar');

        $request->validate([
            'archivo' => ['required', File::types(['csv', 'xls', 'xlsx'])],
        ]);

        try {
            $data = Excel::toArray([], $request->file('archivo'))[0];

            foreach (array_slice($data, 1) as $row) {
                [$matricula, $nombreCompleto, $materiaGrupo, $carrera] = $row;

                if (!$matricula || !$nombreCompleto) continue;

                $partes = explode(' ', $nombreCompleto, 2);
                $nombre = trim($partes[0]);
                $apellidos = isset($partes[1]) ? trim($partes[1]) : 'Sin Apellidos';

                $correo = $matricula . '@tecvalles.mx';
                $password = Hash::make('12345678');

                $user = User::firstOrCreate(
                    ['email' => $correo],
                    [
                        'name' => trim($nombre . ' ' . $apellidos),
                        'password' => $password,
                        'rol' => 4,
                    ]
                );

                Estudiante::updateOrCreate(
                    ['users_id' => $user->id],
                    [
                        'matricula' => $matricula,
                        'nombre' => $nombre,
                        'apellidos' => $apellidos,
                        'carrera' => $carrera,
                        'grupo_id' => $grupoId,
                        'correo_institucional' => $correo,
                        'estado' => 'activo',
                    ]
                );
            }

            return back()->with('success', 'Estudiantes importados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

   
    private function authorizeGrupo(Grupo $grupo, $accion = 'ver')
    {
        $user = auth()->user();

        if ($accion === 'ver') {
          
            if ($user->rol_id == 3 && (!$grupo->tutor || $grupo->tutor->users_id !== $user->id)) {
                abort(403, 'No tienes permiso para ver este grupo.');
            }
        }

        if (in_array($accion, ['editar', 'eliminar'])) {
            if (!in_array($user->rol_id, [1,2])) {
                abort(403, 'No tienes permiso para ' . $accion . ' este grupo.');
            }
        }
    }
}
