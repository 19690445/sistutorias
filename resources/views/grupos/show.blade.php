@extends('adminlte::page')

@section('title', 'Estudiantes del Grupo')

@section('content_header')
    <h1>Estudiantes del Grupo: {{ $grupo->nombre_grupo }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('grupos.index') }}" class="btn btn-secondary btn-sm">
            ← Volver
        </a>
    </div>
    <div class="card-body">
        @if($grupo->estudiantes->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Semestre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupo->estudiantes as $estudiante)
                        <tr>
                            <td>{{ $estudiante->matricula }}</td>
                            <td>{{ $estudiante->nombre }} {{ $estudiante->apellidos }}</td>
                            <td>{{ $estudiante->correo_institucional }}</td>
                            <td>{{ $estudiante->semestre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">
                No hay estudiantes registrados en este grupo.
            </div>
        @endif
    </div>
</div>
@stop
