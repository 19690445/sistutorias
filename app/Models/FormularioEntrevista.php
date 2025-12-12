<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioEntrevista extends Model
{
    protected $table = 'formulario_entrevistas';

    protected $fillable = [
        'carrera','numero_control','nombre_completo','edad','genero','estado_civil','fecha_nacimiento',
        'lugar_nacimiento','telefono_celular','telefono_hogar','habla_lengua_indigena',
        'has_trabajado','trabaja_actualmente','horas_trabajo_semana','motivo_trabajo',
        'nombre_padre','nombre_madre','padre_vive','madre_vive','ocupacion_padre','ocupacion_madre',
        'telefono_padre','telefono_madre', 'nivel_educativo_familiar','zona_residencia','tipo_vivienda',
        'tiempo_recorrido_escuela','servicios_vivienda','financiamiento_estudios','ingreso_familiar_mensual',
        'factores_eleccion_carrera','razones_dejar_estudiar','vision_mundo_laboral','ha_estado_becado',
        'tipo_beca','promedio_bachillerato','evaluacion_materias','necesita_ayuda_materias',
        'puede_asesorar_companeros','enfermedad_cronica','enfermedad_cronica_especifica','toma_medicamento',
        'tipo_medicamentos','condiciones_salud','institucion_salud','caracteristicas_personales',
        'relacion_con_padres','actividades_tiempo_libre','meta_vida','ip_address','user_agent'
    ];

    protected $casts = [
        'nivel_educativo_familiar' => 'array',
        'servicios_vivienda' => 'array',
        'financiamiento_estudios' => 'array',
        'factores_eleccion_carrera' => 'array',
        'razones_dejar_estudiar' => 'array',
        'evaluacion_materias' => 'array',
        'necesita_ayuda_materias' => 'array',
        'condiciones_salud' => 'array',
        'caracteristicas_personales' => 'array',
        'relacion_con_padres' => 'array',
        'actividades_tiempo_libre' => 'array',
        'habla_lengua_indigena' => 'boolean',
        'padre_vive' => 'boolean',
        'madre_vive' => 'boolean',
        'trabaja_actualmente' => 'boolean',
        'ha_estado_becado' => 'boolean',
        'puede_asesorar_companeros' => 'boolean',
        'enfermedad_cronica' => 'boolean',
        'toma_medicamento' => 'boolean',
    ];
    
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function puedeEditar($user)
    {
        
        if (in_array($user->role->nombre, ['admin', 'coordinador', 'docente', 'tutor'])) {
            return true;
        }
        
        if ($user->role->nombre === 'tutorado' && $this->user_id == $user->id) {
            return true;
        }
        
        return false;
    }


    public function puedeEliminar($user)
    {
        return $user->isAdmin() || $user->isCoordinador() || $user->isDocente();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function yaContesto($userId)
    {
        return self::where('user_id', $userId)->exists();
    }
}