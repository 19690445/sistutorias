<?php

namespace App\Http\Controllers;

use App\Models\FormularioEntrevista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estudiante;
use PDF;

class FormularioEntrevistaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $role = auth()->user()->role->nombre;

        
        $roles_permitidos = ['admin', 'coordinador', 'docente', 'tutor'];

        if (!in_array($role, $roles_permitidos)) {
            abort(403, 'No tienes permiso.');
        }

        $formularios = FormularioEntrevista::latest()->paginate(20);

        return view('entrevistas.index', compact('formularios'));
    }

    public function create()
    {
        $role = auth()->user()->role->nombre;

        if (!in_array($role, ['admin', 'coordinador', 'docente', 'tutor'])) {
            abort(403, 'No tienes permiso.');
        }

        return view('entrevistas.create');
    }

    public function store(Request $request)
    {
        $role = auth()->user()->role->nombre;

        if (!in_array($role, ['admin', 'coordinador', 'docente', 'tutor'])) {
            abort(403, 'No tienes permiso.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'semestre' => 'required|string|max:50',
            'grupo' => 'required|string|max:50',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();

        FormularioEntrevista::create($validated);

        return redirect()->route('entrevistas.index')
                         ->with('success', 'Formulario guardado correctamente.');
    }


    public function show($id)
    {
        $form = FormularioEntrevista::findOrFail($id);
        $role = auth()->user()->role->nombre;

        
        if ($role === 'tutorado' && $form->user_id != auth()->id()) {
            abort(403, 'No tienes permiso para ver este formulario.');
        }

        return view('entrevistas.show', compact('form'));
    }

//    public function edit(FormularioEntrevista $formulario)
//     {
//         // Verificar permisos usando el método del modelo
//         if (!$formulario->puedeEditar(auth()->user())) {
//             abort(403, 'No tienes permiso para editar este formulario.');
//         }
        
//         return view('entrevistas.edit', compact('formulario'));
//     }
    public function update(Request $request, $id)
    {
        $form = FormularioEntrevista::findOrFail($id);
        $role = auth()->user()->role->nombre;

        if (!in_array($role, ['admin', 'coordinador', 'docente', 'tutor'])) {
            abort(403, 'No tienes permiso.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'semestre' => 'required|string|max:50',
            'grupo' => 'required|string|max:50',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $form->update($validated);

        return redirect()->route('entrevistas.index')
                         ->with('success', 'Formulario actualizado correctamente.');
    }

 public function misEntrevistas()
{
    $user = auth()->user();

    $entrevistas = collect();

    if ($user->hasRole('tutorado')) {
        if ($user->estudiante) {
            $entrevistas = FormularioEntrevista::where('estudiante_id', $user->estudiante->id)->get();
        }
    } elseif ($user->hasRole(['admin', 'coordinador', 'docente'])) {
        $grupos = $user->grupos()->pluck('id');
        $entrevistas = FormularioEntrevista::whereIn('estudiante_id', function($query) use ($grupos) {
            $query->select('id')
                  ->from('estudiantes')
                  ->whereIn('grupo_id', $grupos);
        })->get();
    } else {
        abort(403, 'No autorizado');
    }

    return view('entrevistas.mias', compact('entrevistas'));
}

    public function destroy($id)
    {
        $form = FormularioEntrevista::findOrFail($id);
        $role = auth()->user()->role->nombre;

        if (!in_array($role, ['admin', 'coordinador'])) {
            abort(403, 'No tienes permiso para eliminar.');
        }

        $form->delete();

        return redirect()->route('entrevistas.index')
                         ->with('success', 'Formulario eliminado.');
    }

    public function crearComoTutorado()
{
    if (auth()->user()->role->nombre !== 'tutorado') {
        abort(403, 'No tienes permiso.');
    }

    return view('entrevistas.responder'); 
}

 public function guardarComoTutorado(Request $request)
{
   
    $user = auth()->user();
    $estudiante = $user->estudiante;

    if (!$estudiante) {
        return redirect()->back()->with('error', 'No se encontró el estudiante asociado al usuario.');
    }

    $formulario = new FormularioEntrevista($request->all());

    
    $formulario->estudiante_id = $estudiante->id;

   
    $arrayFields = [
        'nivel_educativo_familiar',
        'servicios_vivienda',
        'factores_eleccion_carrera',
        'razones_dejar_estudiar',
        'evaluacion_materias',
        'necesita_ayuda_materias',
        'enfermedad_cronica',
        'tipo_medicamentos',
        'caracteristicas_personales',
        'relacion_con_padres',
        'actividades_tiempo_libre',
    ];

    foreach ($arrayFields as $field) {
        if ($request->has($field) && is_array($request->input($field))) {
            $formulario->$field = json_encode($request->input($field));
        }
    }

    $formulario->save();

    return redirect()->route('mis-entrevistas')->with('success', 'Formulario guardado correctamente.');
}

}
