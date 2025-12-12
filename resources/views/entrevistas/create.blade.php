@extends('adminlte::page')

@section('title', 'Nuevo Formulario de Entrevista')

@section('content_header')
    <h1>Nuevo Formulario de Entrevista</h1>
@stop

@section('content')

<form action="{{ route('entrevistas.store') }}" method="POST">
    @csrf


<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 1: Datos Personales</h4>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Carrera</label>
                <select name="carrera" class="form-control">
                    <option value="">Seleccione</option>
                    <option value="INGENIERÍA EN SISTEMAS COMPUTACIONALES" {{ old('carrera') == 'INGENIERÍA EN SISTEMAS COMPUTACIONALES' ? 'selected' : '' }}>INGENIERÍA EN SISTEMAS COMPUTACIONALES</option>
                    <option value="INGENIERÍA INDUSTRIAL" {{ old('carrera') == 'INGENIERÍA INDUSTRIAL' ? 'selected' : '' }}>INGENIERÍA INDUSTRIAL</option>
                    <option value="INGENIERÍA EN GESTIÓN EMPRESARIAL" {{ old('carrera') == 'INGENIERÍA EN GESTIÓN EMPRESARIAL' ? 'selected' : '' }}>INGENIERÍA EN GESTIÓN EMPRESARIAL</option>
                    <option value="INGENIERÍA AMBIENTAL" {{ old('carrera') == 'INGENIERÍA AMBIENTAL' ? 'selected' : '' }}>INGENIERÍA AMBIENTAL</option>
                    <option value="INGENIERÍA EN AGRONOMÍA" {{ old('carrera') == 'INGENIERÍA EN AGRONOMÍA' ? 'selected' : '' }}>INGENIERÍA EN AGRONOMÍA</option>
                    <option value="INGENIERÍA EN INTELIGENCIA ARTIFICIAL" {{ old('carrera') == 'INGENIERÍA EN INTELIGENCIA ARTIFICIAL' ? 'selected' : '' }}>INGENIERÍA EN INTELIGENCIA ARTIFICIAL</option>
                    <option value="INGENIERÍA EN ALIMENTARIAS" {{ old('carrera') == 'INGENIERÍA EN ALIMENTARIAS' ? 'selected' : '' }}>INGENIERÍA EN ALIMENTARIAS</option>
                    <option value="INGENIERÍA EN DESARROLLO DE APLICACIONES" {{ old('carrera') == 'INGENIERÍA EN DESARROLLO DE APLICACIONES' ? 'selected' : '' }}>INGENIERÍA EN DESARROLLO DE APLICACIONES</option>
                    <option value="INGENIERÍA INDUSTRIAL" {{ old('carrera') == 'INGENIERÍA INDUSTRIAL' ? 'selected' : '' }}>INGENIERÍA INDUSTRIAL MIXTA</option>
                    <option value="INGENIERÍA EN GESTIÓN EMPRESARIAL" {{ old('carrera') == 'INGENIERÍA EN GESTIÓN EMPRESARIAL' ? 'selected' : '' }}>INGENIERÍA EN GESTIÓN EMPRESARIAL MIXTA</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Número de Control</label>
                <input type="text" name="numero_control" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Nombre Completo</label>
                <input type="text" name="nombre_completo" class="form-control" required>
            </div>

            <div class="col-md-2 mb-3">
                <label>Edad</label>
                <input type="number" name="edad" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Género</label>
                <select name="genero" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                    <option value="prefiero_no_decir">Prefiero no decir</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>Estado Civil</label>
                <select name="estado_civil" class="form-control" required>
                    <option value="soltero">Soltero(a)</option>
                    <option value="casado">Casado(a)</option>
                    <option value="union_libre">Unión libre</option>
                    <option value="divorciado">Divorciado(a)</option>
                    <option value="viudo">Viudo(a)</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Lugar de Nacimiento</label>
                <input type="text" name="lugar_nacimiento" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Teléfono Celular</label>
                <input type="text" name="telefono_celular" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Teléfono Hogar</label>
                <input type="text" name="telefono_hogar" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label>¿Habla lengua indígena?</label>
                <select name="habla_lengua_indigena" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>
        </div>

    </div>
</div>


{{-- SECCIÓN 2: SITUACIÓN LABORAL --}}

<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 2: Situación Laboral</h4>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>¿Has trabajado?</label>
                <select name="has_trabajado" class="form-control" required>
                    <option value="si">Sí</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>¿Trabaja actualmente?</label>
                <select name="trabaja_actualmente" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>Horas de trabajo por semana</label>
                <select name="horas_trabajo_semana" class="form-control">
                    <option value="">Seleccione</option>
                    @foreach(['1-6','7-12','13-20','21-30','31-40','40+'] as $h)
                        <option value="{{ $h }}">{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label>Motivo por el que trabaja</label>
                <textarea name="motivo_trabajo" class="form-control"></textarea>
            </div>
        </div>

    </div>
</div>

{{-- SECCIÓN 3: DATOS FAMILIARES --}}

<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 3: Datos Familiares</h4>
    </div>
    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Nombre del Padre</label>
                <input type="text" name="nombre_padre" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Nombre de la Madre</label>
                <input type="text" name="nombre_madre" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label>¿Padre vive?</label>
                <select name="padre_vive" class="form-control">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>¿Madre vive?</label>
                <select name="madre_vive" class="form-control">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>Ocupación del Padre</label>
                <select name="ocupacion_padre" class="form-control">
                    @foreach([
                        'empleado_publico','empleado_privado','empleada_domestica','empresario','operario',
                        'director_gerente','tecnico','jubilado','trabajador_campo','comerciante',
                        'labores_hogar','otra','no_trabaja'
                    ] as $op)
                        <option value="{{ $op }}">{{ ucfirst(str_replace('_',' ',$op)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>Ocupación de la Madre</label>
                <select name="ocupacion_madre" class="form-control">
                    @foreach([
                        'empleado_publico','empleado_privado','empleada_domestica','empresario','operario',
                        'director_gerente','tecnico','jubilado','trabajador_campo','comerciante',
                        'labores_hogar','otra','no_trabaja'
                    ] as $op)
                        <option value="{{ $op }}">{{ ucfirst(str_replace('_',' ',$op)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>Teléfono Padre</label>
                <input type="text" name="telefono_padre" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label>Teléfono Madre</label>
                <input type="text" name="telefono_madre" class="form-control">
            </div>

        </div>

    </div>
</div>


<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 4: Situación Socioeconómica</h4>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Nivel educativo familiar (marque los que apliquen):</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="nivel_educativo_familiar[]" value="primaria">
                    Primaria
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="nivel_educativo_familiar[]" value="secundaria">
                    Secundaria
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="nivel_educativo_familiar[]" value="preparatoria">
                    Preparatoria
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="nivel_educativo_familiar[]" value="universidad">
                    Universidad
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label>Zona donde vive</label>
                <input type="text" name="zona_residencia" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>Tipo de vivienda</label>
                <input type="text" name="tipo_vivienda" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Tiempo de recorrido a la escuela (minutos)</label>
                <input type="number" name="tiempo_recorrido_escuela" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Servicios con los que cuenta tu vivienda:</label><br>

                @foreach(['luz','agua','drenaje','internet','cable','gas','telefono'] as $srv)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="servicios_vivienda[]" value="{{ $srv }}">
                    {{ ucfirst($srv) }}
                </div>
                @endforeach
            </div>

            <div class="col-md-4 mb-3">
                <label>¿Quién financia tus estudios?</label><br>

                @foreach(['padres','tutor','trabajo_propio','beca','familiar','otro'] as $fin)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="financiamiento_estudios[]" value="{{ $fin }}">
                    {{ ucfirst(str_replace('_',' ',$fin)) }}
                </div>
                @endforeach
            </div>

            <div class="col-md-4 mb-3">
                <label>Ingreso familiar mensual</label>
                <select name="ingreso_familiar_mensual" class="form-control" required>
                    <option value="menos_3000">Menos de $3000</option>
                    <option value="3001_6000">$3001 - $6000</option>
                    <option value="6001_10000">$6001 - $10000</option>
                    <option value="10001_15000">$10001 - $15000</option>
                    <option value="15001_20000">$15001 - $20000</option>
                    <option value="20001_30000">$20001 - $30000</option>
                    <option value="mas_30001">Más de $30001</option>
                </select>
            </div>

        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 5: Orientación Profesional</h4>
    </div>

    <div class="card-body">

        <label>Factores por los que elegiste tu carrera:</label>
        @foreach(['vocacion','influencia_familiar','oportunidad_laboral','costo','cercania','beca'] as $fac)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="factores_eleccion_carrera[]" value="{{ $fac }}">
            {{ ucfirst(str_replace('_',' ',$fac)) }}
        </div>
        @endforeach

        <br>

        <label>Razones por las que dejarías de estudiar:</label>
        @foreach(['economia','salud','desinteres','trabajo','familia','otras'] as $rz)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="razones_dejar_estudiar[]" value="{{ $rz }}">
            {{ ucfirst($rz) }}
        </div>
        @endforeach

        <div class="mt-3">
            <label>¿Cómo ves tu futuro en el mundo laboral?</label>
            <textarea class="form-control" name="vision_mundo_laboral"></textarea>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 6: Rendimiento Académico</h4>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>¿Has estado becado?</label>
                <select name="ha_estado_becado" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Tipo de beca</label>
                <input type="text" name="tipo_beca" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label>Promedio Bachillerato</label>
                <input type="number" step="0.01" name="promedio_bachillerato" class="form-control">
            </div>
        </div>

        <label>Materias en las que tienes mayor facilidad:</label>
        @foreach(['mate','fisica','programacion','quimica','ingles','otra'] as $mat)
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="evaluacion_materias[]" value="{{ $mat }}">
            {{ ucfirst($mat) }}
        </div>
        @endforeach

        <br>

        <label>Materias en las que necesitas ayuda:</label>
        @foreach(['mate','fisica','programacion','quimica','ingles','otra'] as $mat2)
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="necesita_ayuda_materias[]" value="{{ $mat2 }}">
            {{ ucfirst($mat2) }}
        </div>
        @endforeach

        <br>

        <label>¿Puedes asesorar a tus compañeros?</label>
        <select name="puede_asesorar_companeros" class="form-control">
            <option value="0">No</option>
            <option value="1">Sí</option>
        </select>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 7: Salud</h4>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>¿Padeces enfermedad crónica?</label>
                <select name="enfermedad_cronica" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Especifique enfermedad</label>
                <input type="text" name="enfermedad_cronica_especifica" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label>¿Toma medicamento?</label>
                <select name="toma_medicamento" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tipo de medicamentos</label>
                <input type="text" name="tipo_medicamentos" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Condiciones de salud (marque las que apliquen):</label><br>

                @foreach(['hipertension','diabetes','asma','obesidad','alergias','estres','otro'] as $salud)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input"
                           name="condiciones_salud[]" value="{{ $salud }}">
                    {{ ucfirst($salud) }}
                </div>
                @endforeach
            </div>

            <div class="col-md-4 mb-3">
                <label>Institución de salud</label>
                <input type="text" name="institucion_salud" class="form-control">
            </div>

        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h4>SECCIÓN 8: Aspectos Personales</h4>
    </div>

    <div class="card-body">

        <label>Características personales:</label>
        @foreach(['sociable','timido','lider','creativo','responsable','ansioso'] as $car)
        <div class="form-check">
            <input type="checkbox" class="form-check-input"
                   name="caracteristicas_personales[]" value="{{ $car }}">
            {{ ucfirst($car) }}
        </div>
        @endforeach

        <br>

        <label>Relación con los padres:</label>
        @foreach(['buena','regular','mala','distante'] as $rel)
        <div class="form-check">
            <input type="checkbox" class="form-check-input"
                   name="relacion_con_padres[]" value="{{ $rel }}">
            {{ ucfirst($rel) }}
        </div>
        @endforeach

        <br>

        <label>Actividades en tiempo libre:</label>
        @foreach(['deporte','lectura','videojuegos','musica','tv','salir','otro'] as $act)
        <div class="form-check">
            <input type="checkbox" class="form-check-input"
                   name="actividades_tiempo_libre[]" value="{{ $act }}">
            {{ ucfirst($act) }}
        </div>
        @endforeach

        <div class="mt-3">
            <label>Meta de vida</label>
            <textarea name="meta_vida" class="form-control"></textarea>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-body text-center">
        <button type="submit" class="btn btn-success btn-lg">Guardar Formulario</button>
    </div>
</div>

</form>

@stop

