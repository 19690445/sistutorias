@extends('adminlte::page')

@section('title', 'Ver Grupo')

@section('content_header')
    <h1>Grupo: {{ $grupo->nombre_grupo }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Clave:</strong> {{ $grupo->clave_grupo }}</p>
            <p><strong>Tutor:</strong> {{ $grupo->tutor->nombre ?? '' }}</p>
            <p><strong>Periodo:</strong> {{ $grupo->periodo->nombre ?? '' }}</p>
            <p><strong>Carrera:</strong> {{ $grupo->carrera }}</p>
            <p><strong>Semestre:</strong> {{ $grupo->semestre }}</p>
            <p><strong>Aula:</strong> {{ $grupo->aula }}</p>
            <p><strong>Horario:</strong> {{ $grupo->horario }}</p>
            <p><strong>Capacidad:</strong> {{ $grupo->capacidad_salon }}</p>
            <p><strong>Modalidad:</strong> {{ $grupo->modalidad }}</p>
            <p><strong>Turno:</strong> {{ $grupo->turno }}</p>

            <h3>Estudiantes</h3>
            <ul>
                @foreach($grupo->estudiantes as $estudiante)
                    <li>{{ $estudiante->nombre }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@stop
