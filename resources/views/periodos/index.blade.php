@extends('adminlte::page')

@section('title', 'Periodos')

@section('content_header')
    <h1>Periodos</h1>
    <a href="{{ route('periodos.create') }}" class="btn btn-primary">Nuevo Periodo</a>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Año</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodos as $periodo)
                <tr>
                    <td>{{ $periodo->id }}</td>
                    <td>{{ $periodo->nombre_periodo }}</td>
                    <td>{{ $periodo->año_periodo }}</td>
                    <td>{{ $periodo->fecha_inicio }}</td>
                    <td>{{ $periodo->fecha_fin ?? '-' }}</td>
                    <td>{{ $periodo->estado }}</td>
                    <td>
                        <a href="{{ route('periodos.edit', $periodo->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('periodos.destroy', $periodo->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Desea eliminar este periodo?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
