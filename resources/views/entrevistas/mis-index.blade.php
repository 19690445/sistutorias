@extends('adminlte::page')

@section('title', 'Mis Entrevistas')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Mi Formulario de Entrevista</h2>

    @if ($entrevista)
        {{-- SECCIÓN 1: Datos Personales --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Datos Personales</div>
            <div class="card-body">
                <p><strong>Carrera:</strong> {{ $entrevista->carrera }}</p>
                <p><strong>Número de Control:</strong> {{ $entrevista->numero_control }}</p>
                <p><strong>Nombre Completo:</strong> {{ $entrevista->nombre_completo }}</p>
                <p><strong>Edad:</strong> {{ $entrevista->edad }}</p>
                <p><strong>Género:</strong> {{ ucfirst($entrevista->genero) }}</p>
                <p><strong>Estado Civil:</strong> {{ ucfirst($entrevista->estado_civil) }}</p>
                <p><strong>Fecha de Nacimiento:</strong> {{ $entrevista->fecha_nacimiento }}</p>
                <p><strong>Lugar de Nacimiento:</strong> {{ $entrevista->lugar_nacimiento }}</p>
                <p><strong>Teléfono Celular:</strong> {{ $entrevista->telefono_celular }}</p>
                <p><strong>Teléfono Hogar:</strong> {{ $entrevista->telefono_hogar ?? 'No registrado' }}</p>
                <p><strong>Habla lengua indígena:</strong> {{ $entrevista->habla_lengua_indigena ? 'Sí' : 'No' }}</p>
            </div>
        </div>

        {{-- SECCIÓN 2: Situación Laboral --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Situación Laboral</div>
            <div class="card-body">
                <p><strong>Ha trabajado:</strong> {{ ucfirst($entrevista->has_trabajado) }}</p>
                <p><strong>Trabaja actualmente:</strong> {{ $entrevista->trabaja_actualmente ? 'Sí' : 'No' }}</p>
                <p><strong>Horas de trabajo por semana:</strong> {{ $entrevista->horas_trabajo_semana ?? 'No registrado' }}</p>
                <p><strong>Motivo por el que trabaja:</strong> {{ $entrevista->motivo_trabajo ?? 'No registrado' }}</p>
            </div>
        </div>

        {{-- SECCIÓN 3: Datos Familiares --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Datos Familiares</div>
            <div class="card-body">
                <p><strong>Nombre del Padre:</strong> {{ $entrevista->nombre_padre ?? 'No registrado' }}</p>
                <p><strong>Nombre de la Madre:</strong> {{ $entrevista->nombre_madre ?? 'No registrado' }}</p>
                <p><strong>Padre vive:</strong> {{ $entrevista->padre_vive ? 'Sí' : 'No' }}</p>
                <p><strong>Madre vive:</strong> {{ $entrevista->madre_vive ? 'Sí' : 'No' }}</p>
                <p><strong>Ocupación del Padre:</strong> {{ ucfirst(str_replace('_',' ',$entrevista->ocupacion_padre)) }}</p>
                <p><strong>Ocupación de la Madre:</strong> {{ ucfirst(str_replace('_',' ',$entrevista->ocupacion_madre)) }}</p>
                <p><strong>Teléfono Padre:</strong> {{ $entrevista->telefono_padre ?? 'No registrado' }}</p>
                <p><strong>Teléfono Madre:</strong> {{ $entrevista->telefono_madre ?? 'No registrado' }}</p>
            </div>
        </div>

        {{-- SECCIÓN 4: Situación Socioeconómica --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Situación Socioeconómica</div>
            <div class="card-body">
                <p><strong>Nivel educativo familiar:</strong></p>
                @if($entrevista->nivel_educativo_familiar)
                    <ul>
                        @foreach($entrevista->nivel_educativo_familiar as $ne)
                            <li>{{ ucfirst($ne) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Zona de residencia:</strong> {{ $entrevista->zona_residencia }}</p>
                <p><strong>Tipo de vivienda:</strong> {{ $entrevista->tipo_vivienda }}</p>
                <p><strong>Tiempo de recorrido a la escuela:</strong> {{ $entrevista->tiempo_recorrido_escuela }} minutos</p>

                <p><strong>Servicios en vivienda:</strong></p>
                @if($entrevista->servicios_vivienda)
                    <ul>
                        @foreach($entrevista->servicios_vivienda as $srv)
                            <li>{{ ucfirst($srv) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Financiamiento de estudios:</strong></p>
                @if($entrevista->financiamiento_estudios)
                    <ul>
                        @foreach($entrevista->financiamiento_estudios as $fin)
                            <li>{{ ucfirst(str_replace('_',' ',$fin)) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Ingreso familiar mensual:</strong> {{ ucfirst(str_replace('_',' ',$entrevista->ingreso_familiar_mensual)) }}</p>
            </div>
        </div>

        {{-- SECCIÓN 5: Orientación Profesional --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Orientación Profesional</div>
            <div class="card-body">
                <p><strong>Factores por los que eligió su carrera:</strong></p>
                @if($entrevista->factores_eleccion_carrera)
                    <ul>
                        @foreach($entrevista->factores_eleccion_carrera as $fac)
                            <li>{{ ucfirst(str_replace('_',' ',$fac)) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Razones por las que dejaría de estudiar:</strong></p>
                @if($entrevista->razones_dejar_estudiar)
                    <ul>
                        @foreach($entrevista->razones_dejar_estudiar as $rz)
                            <li>{{ ucfirst(str_replace('_',' ',$rz)) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Visión del futuro laboral:</strong> {{ $entrevista->vision_mundo_laboral ?? 'No registrado' }}</p>
            </div>
        </div>

        {{-- SECCIÓN 6: Rendimiento Académico --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Rendimiento Académico</div>
            <div class="card-body">
                <p><strong>Ha estado becado:</strong> {{ $entrevista->ha_estado_becado ? 'Sí' : 'No' }}</p>
                <p><strong>Tipo de beca:</strong> {{ $entrevista->tipo_beca ?? 'No registrado' }}</p>
                <p><strong>Promedio Bachillerato:</strong> {{ $entrevista->promedio_bachillerato ?? 'No registrado' }}</p>

                <p><strong>Materias con mayor facilidad:</strong></p>
                @if($entrevista->evaluacion_materias)
                    <ul>
                        @foreach($entrevista->evaluacion_materias as $mat)
                            <li>{{ ucfirst($mat) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Materias en las que necesita ayuda:</strong></p>
                @if($entrevista->necesita_ayuda_materias)
                    <ul>
                        @foreach($entrevista->necesita_ayuda_materias as $mat2)
                            <li>{{ ucfirst($mat2) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Puede asesorar a compañeros:</strong> {{ $entrevista->puede_asesorar_companeros ? 'Sí' : 'No' }}</p>
            </div>
        </div>

        {{-- SECCIÓN 7: Salud --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Salud</div>
            <div class="card-body">
                <p><strong>Padece enfermedad crónica:</strong> {{ $entrevista->enfermedad_cronica ? 'Sí' : 'No' }}</p>
                <p><strong>Especifique enfermedad:</strong> {{ $entrevista->enfermedad_cronica_especifica ?? 'No registrado' }}</p>
                <p><strong>Toma medicamento:</strong> {{ $entrevista->toma_medicamento ? 'Sí' : 'No' }}</p>
                <p><strong>Tipo de medicamentos:</strong> {{ $entrevista->tipo_medicamentos ?? 'No registrado' }}</p>

                <p><strong>Condiciones de salud:</strong></p>
                @if($entrevista->condiciones_salud)
                    <ul>
                        @foreach($entrevista->condiciones_salud as $cond)
                            <li>{{ ucfirst($cond) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Institución de salud:</strong> {{ $entrevista->institucion_salud ?? 'No registrado' }}</p>
            </div>
        </div>

        {{-- SECCIÓN 8: Aspectos Personales --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Aspectos Personales</div>
            <div class="card-body">
                <p><strong>Características personales:</strong></p>
                @if($entrevista->caracteristicas_personales)
                    <ul>
                        @foreach($entrevista->caracteristicas_personales as $car)
                            <li>{{ ucfirst($car) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Relación con los padres:</strong></p>
                @if($entrevista->relacion_con_padres)
                    <ul>
                        @foreach($entrevista->relacion_con_padres as $rel)
                            <li>{{ ucfirst($rel) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Actividades en tiempo libre:</strong></p>
                @if($entrevista->actividades_tiempo_libre)
                    <ul>
                        @foreach($entrevista->actividades_tiempo_libre as $act)
                            <li>{{ ucfirst(str_replace('_',' ',$act)) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No registrado</p>
                @endif

                <p><strong>Meta de vida:</strong> {{ $entrevista->meta_vida ?? 'No registrado' }}</p>
            </div>
        </div>

    @else
        <p class="text-center">No tienes entrevistas registradas aún.</p>
    @endif
</div>
@endsection
