<?php
// app/Http\Controllers\EntrevistaController.php

namespace App\Http\Controllers;

use App\Models\EntrevistaIndividual;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\Grupo;
use App\Models\Periodo;
use Illuminate\Http\Request;

class EntrevistaController extends Controller
{
    public function create()
    {
        return view('entrevistas.create', [
            // Estudiantes SÍ tienen 'estado'
            'estudiantes' => Estudiante::where('estado', 'activo')->get(),
            
            // Tutores SÍ tienen 'estado'
            'tutores' => Tutor::where('estado', 'activo')->get(),
            
            // Grupos NO tienen 'estado', así que traemos todos
            'grupos' => Grupo::all(),
            
            // Periodos - no sé si tienen columna 'activo', por seguridad usamos all()
            'periodos' => Periodo::all(),
        ]);
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'tutor_id' => 'nullable|exists:tutores,id',
            'grupo_id' => 'nullable|exists:grupos,id',
            'periodo_id' => 'nullable|exists:periodos,id',
            'carrera' => 'required|string|max:20',
            'numero_control' => 'required|string|max:20',
            'nombre_completo' => 'required|string|max:200',
            'edad' => 'required|integer|min:15|max:60',
            'genero' => 'required|in:masculino,femenino,otro,prefiero_no_decir',
            'estado_civil' => 'required|in:soltero,casado,union_libre,divorciado,viudo,otro',
            'habla_lengua_indigena' => 'required|boolean',
            'fecha_nacimiento' => 'required|date',
            'lugar_nacimiento' => 'required|string|max:200',
            'telefono_celular' => 'required|string|max:15',
            'telefono_hogar' => 'nullable|string|max:15',
            'has_trabajado' => 'nullable|string|max:15',
            'trabaja_actualmente' => 'nullable|boolean',
            'horas_trabajo_semana' => 'nullable|in:1-6,7-12,13-20,21-30,31-40,40+',
            'motivo_trabajo' => 'nullable|string',
            'nombre_padre' => 'required|string|max:200',
            'nombre_madre' => 'required|string|max:200',
            'padre_vive' => 'required|boolean',
            'madre_vive' => 'required|boolean',
            'ocupacion_padre' => 'required|string',
            'ocupacion_madre' => 'required|string',
            'telefono_padre' => 'nullable|string|max:15',
            'telefono_madre' => 'nullable|string|max:15',
            'nivel_educativo_familiar' => 'nullable|array',
            'zona_residencia' => 'required|string|max:50',
            'tipo_vivienda' => 'required|string|max:50',
            'tiempo_recorrido_escuela' => 'required|integer|min:0|max:240',
            'servicios_vivienda' => 'nullable|array',
            'financiamiento_estudios' => 'nullable|array',
            'ingreso_familiar_mensual' => 'required|string',
            'factores_eleccion_carrera' => 'nullable|array',
            'razones_dejar_estudiar' => 'nullable|array',
            'vision_mundo_laboral' => 'required|string',
            'ha_estado_becado' => 'required|boolean',
            'tipo_beca' => 'nullable|string|max:100',
            'promedio_bachillerato' => 'required|numeric|min:0|max:10',
            'evaluacion_materias' => 'nullable|array',
            'necesita_ayuda_materias' => 'nullable|array',
            'puede_asesorar_companeros' => 'required|boolean',
            'enfermedad_cronica' => 'required|boolean',
            'enfermedad_cronica_especifica' => 'nullable|string|max:300',
            'toma_medicamento' => 'required|boolean',
            'tipo_medicamentos' => 'nullable|string|max:500',
            'condiciones_salud' => 'nullable|array',
            'institucion_salud' => 'nullable|string|max:100',
            'caracteristicas_personales' => 'nullable|array',
            'relacion_con_padres' => 'nullable|array',
            'actividades_tiempo_libre' => 'nullable|array',
            'meta_vida' => 'required|string',
        ]);

        // Agregar el usuario autenticado
        $validated['user_id'] = auth()->id();
        
        // Convertir valores booleanos
        $validated['habla_lengua_indigena'] = (bool) $request->habla_lengua_indigena;
        $validated['padre_vive'] = (bool) $request->padre_vive;
        $validated['madre_vive'] = (bool) $request->madre_vive;
        $validated['ha_estado_becado'] = (bool) $request->ha_estado_becado;
        $validated['puede_asesorar_companeros'] = (bool) $request->puede_asesorar_companeros;
        $validated['enfermedad_cronica'] = (bool) $request->enfermedad_cronica;
        $validated['toma_medicamento'] = (bool) $request->toma_medicamento;
        
        // Manejar trabajo actualmente (viene como string 'on' o null)
        $validated['trabaja_actualmente'] = $request->has('trabaja_actualmente') ? true : false;
        
        // Procesar arrays para JSON
        $arraysToJson = [
            'nivel_educativo_familiar',
            'servicios_vivienda',
            'financiamiento_estudios',
            'factores_eleccion_carrera',
            'razones_dejar_estudiar',
            'evaluacion_materias',
            'necesita_ayuda_materias',
            'condiciones_salud',
            'caracteristicas_personales',
            'relacion_con_padres',
            'actividades_tiempo_libre'
        ];
        
        foreach ($arraysToJson as $field) {
            if (isset($validated[$field]) && is_array($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            } else {
                $validated[$field] = null;
            }
        }

        // Crear la entrevista
        try {
            $entrevista = EntrevistaIndividual::create($validated);
            
            return redirect()->route('entrevistas.show', $entrevista->id)
                ->with('success', 'Entrevista individual creada exitosamente.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Error al crear la entrevista: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $entrevista = EntrevistaIndividual::with(['estudiante', 'tutor', 'grupo', 'periodo', 'entrevistador'])
            ->findOrFail($id);
            
        return view('entrevistas.show', compact('entrevista'));
    }
}