<?php

namespace App\Http\Controllers;

use App\Models\Tutorado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTutoradoController extends Controller
{
    // Listar todos los tutorados
    public function index()
    {
        $tutorados = \App\Models\Tutorado::all();

        // 🔹 Detectamos el rol del usuario logueado
        $user = auth()->user();

        // Si es coordinador, usa la misma vista del admin
        if ($user->role->nombre === 'coordinador') {
            return view('admin.tutorados.index', compact('tutorados'));
        }

        // Si es admin, también usa la vista del admin
        return view('admin.tutorados.index', compact('tutorados'));
    }


    // Mostrar formulario de creación (solo admin)
    public function create()
    {
        return view('admin.tutorados.create');
    }

    // Guardar nuevo tutorado (solo admin)
    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|string|max:50|unique:estudiantes',
            'correo_institucional' => 'required|email|max:100|unique:estudiantes',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'carrera' => 'required|string|max:100',
            'semestre' => 'required|integer|min:1|max:12',
            'estado' => 'required|string',
        ]);

        Tutorado::create($request->all());

        return redirect()->route('admin.tutorados.index')
                         ->with('success', 'Tutorado registrado correctamente.');
    }

    // Mostrar formulario de edición (admin y coordinador)
    public function edit($id)
{
        $tutorado = \App\Models\Tutorado::findOrFail($id);
    $user = auth()->user();

    // ✅ Si el usuario es coordinador, usamos la vista del admin
    if ($user->role->nombre === 'coordinador') {
        return view('admin.tutorados.edit', compact('tutorado'));
    }

    // ✅ Si es admin, también usamos la misma vista
    return view('admin.tutorados.edit', compact('tutorado'));
    }


    // Actualizar tutorado (admin y coordinador)
    public function update(Request $request, $id)
    {
        $tutorado = Tutorado::findOrFail($id);

        $request->validate([
            'matricula' => 'required|string|max:50|unique:estudiantes,matricula,' . $tutorado->id,
            'correo_institucional' => 'required|email|max:100|unique:estudiantes,correo_institucional,' . $tutorado->id,
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'carrera' => 'required|string|max:100',
            'semestre' => 'required|integer|min:1|max:12',
            'estado' => 'required|string',
        ]);

        $tutorado->update($request->all());

        // 🔹 Redirigir correctamente según el rol
        $user = Auth::user();
        $route = $user->role->nombre === 'coordinador'
            ? 'coordinador.tutorados.index'
            : 'admin.tutorados.index';

        return redirect()->route($route)
                         ->with('success', 'Tutorado actualizado correctamente.');
    }

    // Eliminar tutorado (solo admin)
    public function destroy($id)
    {
        $tutorado = Tutorado::findOrFail($id);
        $tutorado->delete();

        return redirect()->route('admin.tutorados.index')
                         ->with('success', 'Tutorado eliminado correctamente.');
    }
}
