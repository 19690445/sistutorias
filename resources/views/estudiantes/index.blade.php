@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('content_header')
    <h1>Listado de Estudiantes</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('estudiantes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear nuevo estudiante
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Carrera</th>
                    <th>Semestre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($estudiantes as $est)
                <tr>
                    <td>{{ $est->matricula }}</td>
                    <td>{{ $est->nombre }} {{ $est->apellidos }}</td>
                    <td>{{ $est->correo_institucional }}</td>
                    <td>{{ $est->carrera }}</td>
                    <td>{{ $est->semestre }}</td>
                    <td>
                        <a href="{{ route('estudiantes.edit', $est->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('estudiantes.destroy', $est->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar estudiante?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
