@extends('adminlte::page')
@section('title', 'Tutorados')

@section('content_header')
<h1>Lista de Tutorados</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('estudiantes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Tutorado
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estudiantes as $e)
                <tr>
                    <td>{{ $e->matricula }}</td>
                    <td>{{ $e->nombre }} {{ $e->apellidos }}</td>
                    <td>{{ $e->correo_institucional }}</td>
                    <td>{{ $e->carrera }}</td>
                    <td>
                        <a href="{{ route('estudiantes.edit', $e->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('estudiantes.destroy', $e->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
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
