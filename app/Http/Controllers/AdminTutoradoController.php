<?php

namespace App\Http\Controllers;

use App\Models\Tutorado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTutoradoController extends Controller
{
    
    public function index()
    {
        $tutorados = \App\Models\Tutorado::all();

        
        $user = auth()->user();

        
        if ($user->role->nombre === 'coordinador') {
            return view('admin.tutorados.index', compact('tutorados'));
        }

        return view('admin.tutorados.index', compact('tutorados'));
    }


    
    public function create()
    {
        return view('admin.tutorados.create');
    }

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

    
    public function edit($id)
{
        $tutorado = \App\Models\Tutorado::findOrFail($id);
    $user = auth()->user();

   
    if ($user->role->nombre === 'coordinador') {
        return view('admin.tutorados.edit', compact('tutorado'));
    }

    
    return view('admin.tutorados.edit', compact('tutorado'));
    }

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

       
        $user = Auth::user();
        $route = $user->role->nombre === 'coordinador'
            ? 'coordinador.tutorados.index'
            : 'admin.tutorados.index';

        return redirect()->route($route)
                         ->with('success', 'Tutorado actualizado correctamente.');
    }

    
    public function destroy($id)
    {
        $tutorado = Tutorado::findOrFail($id);
        $tutorado->delete();

        return redirect()->route('admin.tutorados.index')
                         ->with('success', 'Tutorado eliminado correctamente.');
    }
}
