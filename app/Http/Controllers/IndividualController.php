<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Periodo;
use App\Models\Tutor;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class IndividualController extends Controller
{

    public function index()
    {
        $individuales = Individual::with(['periodo', 'tutor', 'estudiante'])
            ->withCount('canalizaciones')
            ->latest()
            ->paginate(15);
        
        return view('individuales.index', compact('individuales'));
    }

   
    public function create()
    {
       
        $periodos = Periodo::all();
        $tutores = Tutor::all();   
        $estudiantes = Estudiante::all(); 
        
        return view('individuales.create', compact('periodos', 'tutores', 'estudiantes'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'periodo_id' => 'required|exists:periodo,id',
            'tutores_id' => 'required|exists:tutores,id',
            'estudiantes_id' => 'required|exists:estudiantes,id',
            'requiere_canalizacion' => 'required|in:si,no',
            'motivo' => 'nullable|string|max:500',
            'estado' => 'required|in:pendiente,en_proceso,completado',
        ]);

        $existente = Individual::where('periodo_id', $request->periodo_id)
            ->where('estudiantes_id', $request->estudiantes_id)
            ->first();

        if ($existente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Este estudiante ya tiene un registro en el período seleccionado.');
        }

        if ($request->requiere_canalizacion == 'si') {
            $request->merge(['estado' => 'pendiente']);
        } else {
            $request->merge(['estado' => 'completado']);
        }

        $individual = Individual::create($request->all());

        return redirect()->route('individuales.index')
            ->with('success', 'Registro individual creado exitosamente.');
    }

    
    public function show(Individual $individuale)
    {
        $individuale->load(['periodo', 'tutor', 'estudiante', 'canalizaciones']);
        return view('individuales.show', compact('individuale'));
    }

    
    public function edit(Individual $individuale)
    {
        $periodos = Periodo::all(); 
        $tutores = Tutor::all();    
        $estudiantes = Estudiante::all(); 
        
        return view('individuales.edit', compact('individuale', 'periodos', 'tutores', 'estudiantes'));
    }

  
    public function update(Request $request, Individual $individuale)
    {
        $request->validate([
            'periodo_id' => 'required|exists:periodo,id',
            'tutores_id' => 'required|exists:tutores,id',
            'estudiantes_id' => 'required|exists:estudiantes,id',
            'requiere_canalizacion' => 'required|in:si,no',
            'motivo' => 'nullable|string|max:500',
            'estado' => 'required|in:pendiente,en_proceso,completado',
        ]);

       
        if ($request->requiere_canalizacion == 'si' && $individuale->requiere_canalizacion == 'no') {
            $request->merge(['estado' => 'pendiente']);
        }

    
        if ($request->requiere_canalizacion == 'no' && $individuale->requiere_canalizacion == 'si') {
            $request->merge(['estado' => 'completado']);
        }

        $individuale->update($request->all());

        return redirect()->route('individuales.index')
            ->with('success', 'Registro individual actualizado exitosamente.');
    }

  
    public function destroy(Individual $individuale)
    {
      
        if ($individuale->canalizaciones()->count() > 0) {
            return redirect()->route('individuales.index')
                ->with('error', 'No se puede eliminar porque tiene canalizaciones asociadas.');
        }

        $individuale->delete();

        return redirect()->route('individuales.index')
            ->with('success', 'Registro individual eliminado exitosamente.');
    }

    public function verificar(Request $request)
    {
        $request->validate([
            'estudiantes_id' => 'required|exists:estudiantes,id',
            'periodo_id' => 'required|exists:periodo,id',
            'individual_id' => 'nullable|exists:individuales,id',
        ]);

        $query = Individual::with(['estudiante', 'tutor'])
            ->where('estudiantes_id', $request->estudiantes_id)
            ->where('periodo_id', $request->periodo_id);

        if ($request->individual_id) {
            $query->where('id', '!=', $request->individual_id);
        }

        $individual = $query->first();

        if ($individual) {
            return response()->json([
                'existe' => true,
                'estudiante_nombre' => $individual->estudiante->nombre . ' ' . $individual->estudiante->apellido,
                'tutor_nombre' => $individual->tutor->nombre . ' ' . $individual->tutor->apellido,
            ]);
        }

        return response()->json(['existe' => false]);
    }

    
    public function crearCanalizacion(Individual $individuale)
    {
        if ($individuale->requiere_canalizacion != 'si') {
            return redirect()->route('individuales.show', $individuale)
                ->with('error', 'Este registro no requiere canalización.');
        }

        if ($individuale->estado == 'completado') {
            return redirect()->route('individuales.show', $individuale)
                ->with('error', 'Este registro ya está completado.');
        }

        return redirect()->route('canalizaciones.create', ['individual_id' => $individuale->id])
            ->with('success', 'Redirigiendo al formulario de canalización.');
    }
}