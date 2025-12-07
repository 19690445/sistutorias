<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorado;
use App\Models\Role;
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
    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|unique:estudiantes,matricula',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo_institucional' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
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

        Tutorado::create([
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

        return redirect()->route('admin.tutorados.index')
            ->with('success', 'Tutorado registrado correctamente.');
    }
}
