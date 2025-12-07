<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::orderBy('nombre')->get();
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|unique:estudiantes,matricula',
            'correo_institucional' => 'required|email|unique:users,email',
            'nombre' => 'required',
            'apellidos' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nombre . ' ' . $request->apellidos,
            'email' => $request->correo_institucional,
            'password' => bcrypt($request->matricula),
            'rol' => 'tutorado'
        ]);


        Estudiante::create([
            'users_id' => $user->id,
            'matricula' => $request->matricula,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'curp' => $request->curp,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'correo_institucional' => $request->correo_institucional,
            'telefono_celular' => $request->telefono_celular,
            'domicilio' => $request->domicilio,
            'carrera' => $request->carrera,
            'semestre' => $request->semestre,
            'estado' => $request->estado,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_egreso' => $request->fecha_egreso,
        ]);

        return redirect()->route('estudiantes.index')
            ->with('success','Tutorado creado correctamente');
    }

    public function edit($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            'matricula' => 'required|unique:estudiantes,matricula,' . $id,
            'correo_institucional' => 'required|email|unique:users,email,' . $estudiante->users_id,
        ]);

        $estudiante->update($request->all());

        if ($estudiante->users_id) {
            $user = User::find($estudiante->users_id);
            if ($user) {
                $user->update([
                    'email' => $request->correo_institucional,
                    'name'  => $request->nombre . ' ' . $request->apellidos,
                ]);
            }
        }

        return redirect()->route('estudiantes.index')
            ->with('success','Tutorado actualizado correctamente');
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        if ($estudiante->users_id) {
            User::destroy($estudiante->users_id);
        }

        $estudiante->delete();

        return back()->with('success','Tutorado eliminado');
    }

    public function indexDocente()
    {
        $estudiantes = Estudiante::select(
            'matricula',
            'nombre',
            'apellidos',
            'carrera',
            'semestre'
        )->get();

        return view('estudiantes.docente', compact('estudiantes'));
    }

    public function perfil()
    {
        $userId = Auth::id();

        $estudiante = Estudiante::where('users_id', $userId)->firstOrFail();

        return view('estudiantes.perfil', compact('estudiante'));
    }

    public function updatePerfil(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        if ($estudiante->users_id !== Auth::id()) {
            abort(403);
        }

        $estudiante->update($request->all());

        return back()->with('success','Datos actualizados correctamente');
    }
}
