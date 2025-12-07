<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Role;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorizeRoles(['admin', 'coordinador']);

        $tutores = Tutor::all();
        return view('docente.index', compact('tutores'));
    }
    public function create()
    {
        $this->authorizeRoles(['admin', 'coordinador']);
        return view('docente.create');
    }

       public function store(Request $request)
{

    $data = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'curp' => 'nullable|string|max:18',
        'fecha_nacimiento' => 'nullable|date',
        'sexo' => 'nullable|string',
        'correo_electronico' => 'required|email|unique:tutores',
        'password' => 'required|min:6|confirmed',
        'telefono' => 'nullable|string|max:20',
        'departamento' => 'nullable|string|max:100',
        'rfc' => 'nullable|string|max:13',
        'nivel_estudios' => 'nullable|string|max:100',
        'descripcion_estudios' => 'nullable|string',
        'estado' => 'nullable|string',
        'foto_perfil' => 'nullable|image|max:2048',
    ]);
   
    $roldocente = Role::where('nombre', 'docente')->firstOrFail();


    $user = User::create([
        'name' => $data['nombre'] . ' ' . $data['apellidos'],
        'email' => $data['correo_electronico'],
        'password' => Hash::make($data['password']),
        'rol_id' => $roldocente->id,
    ]);

    
    $fotoPath = null;
    if ($request->hasFile('foto_perfil')) {
        $fotoPath = $request->file('foto_perfil')->store('tutores', 'public');
    }

    
    $tutor = Tutor::create([
        'users_id' => $user->id,
        'nombre' => $data['nombre'],
        'apellidos' => $data['apellidos'],
        'curp' => $data['curp'] ?? null,
        'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
        'sexo' => $data['sexo'] ?? null,
        'correo_electronico' => $data['correo_electronico'],
        'telefono' => $data['telefono'] ?? null,
        'departamento' => $data['departamento'] ?? null,
        'rfc' => $data['rfc'] ?? null,
        'nivel_estudios' => $data['nivel_estudios'] ?? null,
        'descripcion_estudios' => $data['descripcion_estudios'] ?? null,
        'estado' => $data['estado'] ?? 'activo',
        'foto_perfil' => $fotoPath,
    ]);

    return redirect()->route('tutores.index')->with('success', 'Tutor registrado correctamente.');
}


   
    public function edit(Tutor $tutor)
    {
        if (Auth::user()->hasRole('tutor') && Auth::id() != $tutor->users_id) {
            abort(403, 'No tienes permisos para editar a este tutor.');
        }

        return view('docente.edit', compact('tutor'));
    }

    public function update(Request $request, Tutor $tutor)
    {
        if (Auth::user()->hasRole('tutor') && Auth::id() != $tutor->users_id) {
            abort(403, 'No tienes permisos para actualizar a este tutor.');
        }

        $data = $request->validate([
            'nombre' => 'required|max:100',
            'apellidos' => 'required|max:100',
            'correo_electronico' => 'required|email|unique:tutores,correo_electronico,' . $tutor->id,
            'curp' => 'nullable|max:18',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:masculino,femenino,otro',
            'telefono' => 'nullable|max:20',
            'departamento' => 'nullable|max:100',
            'rfc' => 'nullable|max:13',
            'nivel_estudios' => 'nullable|max:100',
            'descripcion_estudios' => 'nullable',
            'estado' => 'required|in:activo,inactivo',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto_perfil')) {
            $data['foto_perfil'] = $request->file('foto_perfil')->store('tutores', 'public');
        }

        $tutor->update($data);

        return redirect()->route('tutores.index')->with('success', 'Tutor actualizado correctamente.');
    }

    public function destroy(Tutor $tutor)
    {
        $this->authorizeRoles(['admin', 'coordinador']);

        if ($tutor->foto_perfil) {
            Storage::disk('public')->delete($tutor->foto_perfil);
        }

        $tutor->delete();

        return redirect()->route('tutores.index')->with('success', 'Tutor eliminado correctamente.');
    }

    public function perfil()
    {
        $tutor = Tutor::where('users_id', Auth::id())->firstOrFail();
        return view('docente.perfil', compact('tutor'));
    }

   
    public function actualizarPerfil(Request $request)
    {
        $tutor = Tutor::where('users_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'nombre' => 'required|max:100',
            'apellidos' => 'required|max:100',
            'correo_electronico' => 'required|email|unique:tutores,correo_electronico,' . $tutor->id,
            'telefono' => 'nullable|max:20',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto_perfil')) {
            if ($tutor->foto_perfil) {
                Storage::disk('public')->delete($tutor->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('tutores', 'public');
        }

        $tutor->update($data);

        return redirect()->route('tutores.perfil')->with('success', 'Perfil actualizado correctamente.');
    }


    private function authorizeRoles(array $roles)
    {
        foreach ($roles as $role) {
            if (Auth::user()->hasRole($role)) return true;
        }
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}
