<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorado;
use App\Models\Role;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;

class TutoradoController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $tutorado = Tutorado::where('users_id', $user->id)->first();

         
        if (!$tutorado) {
            return view('tutorado.dashboard')->with('tutorado', null);
        }

        return view('tutorado.dashboard', compact('tutorado'));
    }

    public function create()
{
    $grupos = \App\Models\Grupo::all();
    return view('admin.tutorados.create', compact('grupos'));
}

    public function store(Request $request)
{
    $request->validate([
        'matricula' => 'required|unique:estudiantes,matricula',
        'nombre' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'correo_institucional' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'grupo_id' => 'required|exists:grupos,id', 
    ]);

    $rolTutorado = Role::where('nombre', 'tutorado')->first();

    if (!$rolTutorado) {
        return back()->withErrors(['rol' => 'El rol tutorado no existe']);
    }

    $user = User::create([
        'name' => $request->nombre . ' ' . $request->apellidos,
        'email' => $request->correo_institucional,
        'password' => Hash::make($request->password),
        'rol_id' => $rolTutorado->id,
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
        'grupo_id' => $request->grupo_id, 
    ]);

    return redirect()->route('admin.tutorados.index')
        ->with('success', 'Estudiante registrado correctamente.');
}
    public function show()
    {
        $user = Auth::user();
        $tutorado = Tutorado::where('users_id', $user->id)->first();

        return view('tutorado.perfil', compact('tutorado'));
    }
    public function showPerfil()
    {
        $user = auth()->user();
        $tutorado = $user->estudiante; 
        return view('tutorado.perfil', compact('tutorado'));
    }

    public function editPerfil()
{
    $tutorado = auth()->user()->estudiante; 
    return view('tutorado.edit-perfil', compact('tutorado'));
}

public function update(Request $request)
    {
    
        $user = auth()->user();

        $tutorado = \App\Models\Estudiante::where('users_id', $user->id)->first();

        if (!$tutorado) {
            return redirect()->back()->with('error', 'No se encontró el perfil del tutorado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'curp' => 'nullable|string|max:18',
            'genero' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'domicilio' => 'nullable|string|max:255',
            'telefono_celular' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $tutorado->nombre = $request->nombre;
        $tutorado->apellidos = $request->apellidos;
        $tutorado->curp = $request->curp;
        $tutorado->genero = $request->genero;
        $tutorado->fecha_nacimiento = $request->fecha_nacimiento;
        $tutorado->domicilio = $request->domicilio;
        $tutorado->telefono_celular = $request->telefono_celular;

      
        if ($request->hasFile('foto')) {
            
            if ($tutorado->foto && \Storage::exists($tutorado->foto)) {
                \Storage::delete($tutorado->foto);
            }

            $path = $request->file('foto')->store('tutorados', 'public');
            $tutorado->foto = $path;
        }

        $tutorado->save();

        return redirect()->route('tutorado.perfil')->with('success', 'Perfil actualizado correctamente.');
    }

public function edit()
    {
        
        $tutorado = auth()->user()->estudiante; 

        if (!$tutorado) {
            abort(404, 'No se encontró el tutorado.');
        }

        return view('tutorado.edit', compact('tutorado'));
    }

}
