@extends('adminlte::page')

@section('title', 'Gestión de Tutorados')

@section('content_header')
    <h1>Gestión de Tutorados</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-user-plus"></i> Agregar Tutorado
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Carrera</th>
                <th>Semestre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tutorados as $tutorado)
                <tr>
                    <td>{{ $tutorado->id }}</td>
                    <td>{{ $tutorado->matricula }}</td>
                    <td>{{ $tutorado->nombre }} {{ $tutorado->apellidos }}</td>
                    <td>{{ $tutorado->correo_institucional }}</td>
                    <td>{{ $tutorado->carrera }}</td>
                    <td>{{ $tutorado->semestre }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($tutorado->estado) }}</span></td>
                    <td>
                        <a href="{{ route('admin.estudiantes.edit', $tutorado->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.estudiantes.destroy', $tutorado->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este tutorado?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
