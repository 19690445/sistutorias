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
            'correo_institucional' => 'required|email|unique:estudiantes,correo_institucional',
            'nombre' => 'required',
            'apellidos' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nombre . ' ' . $request->apellidos,
            'email' => $request->correo_institucional,
            'password' => bcrypt('password123'), 
        ]);

        $user->assignRole('estudiante');

        Estudiante::create([
            'users_id' => $user->id,
            'matricula' => $request->matricula,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'correo_institucional' => $request->correo_institucional,
            'curp' => $request->curp,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'telefono_celular' => $request->telefono_celular,
            'domicilio' => $request->domicilio,
            'carrera' => $request->carrera,
            'semestre' => $request->semestre,
            'estado' => $request->estado,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_egreso' => $request->fecha_egreso,
        ]);

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante y usuario creados correctamente');
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
            'matricula' => 'required|unique:estudiantes,matricula,' . $estudiante->id,
            'correo_institucional' => 'required|email|unique:estudiantes,correo_institucional,' . $estudiante->id,
            'nombre' => 'required',
            'apellidos' => 'required',
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante actualizado correctamente');
    }

   
    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante eliminado correctamente');
    }

    
    public function indexDocente()
    {
        $estudiantes = Estudiante::select(
            'matricula',
            'nombre',
            'apellidos',
            'carrera',
            'semestre'
        )->orderBy('nombre')->get();

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
            abort(403, 'No tienes permiso para editar este perfil.');
        }

        $request->validate([
            'correo_institucional' => 'required|email|unique:estudiantes,correo_institucional,' . $estudiante->id,
            'telefono_celular' => 'nullable|string',
            'domicilio' => 'nullable|string',
            'carrera' => 'nullable|string',
            'semestre' => 'nullable|integer',
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.perfil')
            ->with('success', 'Tu información fue actualizada correctamente');
    }
}
