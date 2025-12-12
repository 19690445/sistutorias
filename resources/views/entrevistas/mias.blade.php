@extends('adminlte::page')

@section('title', 'Mis Entrevistas')

@section('content')
<div class="container">
    <h1 class="mb-4">Mis Entrevistas</h1>

    @php
        // Closure para decodificar arrays JSON o retornarlos tal cual
        $decodeArray = function($value) {
            if (is_array($value)) return $value;
            if (is_string($value)) return json_decode($value, true) ?? [];
            return [];
        };
    @endphp

    @forelse($entrevistas as $entrevista)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Entrevista de {{ $entrevista->estudiante->nombre ?? 'Sin nombre' }}
            </div>
            <div class="card-body">

                <h5>Datos Personales</h5>
                <p><strong>Carrera:</strong> {{ $entrevista->carrera ?? 'N/A' }}</p>
                <p><strong>Número de Control:</strong> {{ $entrevista->numero_control ?? 'N/A' }}</p>
                <p><strong>Nombre Completo:</strong> {{ $entrevista->nombre_completo ?? 'N/A' }}</p>
                <p><strong>Edad:</strong> {{ $entrevista->edad ?? 'N/A' }}</p>
                <p><strong>Género:</strong> {{ $entrevista->genero ?? 'N/A' }}</p>

                @php
                    $niveles = $decodeArray($entrevista->nivel_educativo_familiar);
                    $servicios = $decodeArray($entrevista->servicios_vivienda);
                    $finanzas = $decodeArray($entrevista->financiamiento_estudios);
                    $factores = $decodeArray($entrevista->factores_eleccion_carrera);
                    $razones = $decodeArray($entrevista->razones_dejar_estudiar);
                    $materias_facil = $decodeArray($entrevista->evaluacion_materias);
                    $materias_ayuda = $decodeArray($entrevista->necesita_ayuda_materias);
                    $caracteristicas = $decodeArray($entrevista->caracteristicas_personales);
                    $relacion_padres = $decodeArray($entrevista->relacion_con_padres);
                    $actividades = $decodeArray($entrevista->actividades_tiempo_libre);
                @endphp

                <p><strong>Nivel educativo familiar:</strong> {{ implode(', ', $niveles) ?: 'N/A' }}</p>
                <p><strong>Servicios de vivienda:</strong> {{ implode(', ', $servicios) ?: 'N/A' }}</p>
                <p><strong>Financiamiento de estudios:</strong> {{ implode(', ', $finanzas) ?: 'N/A' }}</p>
                <p><strong>Factores elección de carrera:</strong> {{ implode(', ', $factores) ?: 'N/A' }}</p>
                <p><strong>Razones por dejar de estudiar:</strong> {{ implode(', ', $razones) ?: 'N/A' }}</p>
                <p><strong>Materias con facilidad:</strong> {{ implode(', ', $materias_facil) ?: 'N/A' }}</p>
                <p><strong>Materias que necesita ayuda:</strong> {{ implode(', ', $materias_ayuda) ?: 'N/A' }}</p>
                <p><strong>Características personales:</strong> {{ implode(', ', $caracteristicas) ?: 'N/A' }}</p>
                <p><strong>Relación con los padres:</strong> {{ implode(', ', $relacion_padres) ?: 'N/A' }}</p>
                <p><strong>Actividades en tiempo libre:</strong> {{ implode(', ', $actividades) ?: 'N/A' }}</p>

            </div>
        </div>
    @empty
        <p>No hay entrevistas disponibles.</p>
    @endforelse
</div>
@endsection
