@extends('adminlte::page')

@section('title', 'Asistencias')

@section('content_header')
<h1>Lista de Asistencias</h1>
@stop

@section('content')
<a href="{{ route('asistencias.create') }}" class="btn btn-success mb-2">Nueva Asistencia</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Grupo</th>
            <th>Sesión</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Observaciones</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asistencias as $asistencia)
        <tr>
            <td>{{ $asistencia->id }}</td>
            <td>{{ $asistencia->grupo->nombre }}</td>
            <td>{{ $asistencia->sesion }}</td>
            <td>{{ $asistencia->fecha->format('Y-m-d') }}</td>
            <td>{{ $asistencia->estado }}</td>
            <td>{{ $asistencia->observaciones }}</td>
            <td>
                <a href="{{ route('asistencias.edit', $asistencia->id) }}" class="btn btn-primary btn-sm">Editar</a>
                <form action="{{ route('asistencias.destroy', $asistencia->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar asistencia?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
