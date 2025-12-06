@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
    <h1>Listado de Grupos</h1>
@stop

@section('content')
    @if(auth()->user()->rol != 'docente')
        <a href="{{ route('grupos.create') }}" class="btn btn-primary mb-3">Crear Grupo</a>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th>Tutor</th>
                        <th>Periodo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $g)
                        <tr>
                            <td>{{ $g->clave_grupo }}</td>
                            <td>{{ $g->nombre_grupo }}</td>
                            <td>{{ $g->tutor->nombre ?? '' }}</td>
                            <td>{{ $g->periodo->nombre ?? '' }}</td>
                            <td>
                                <a href="{{ route('grupos.show', $g->id) }}" class="btn btn-info btn-sm">Ver</a>

                                @if(auth()->user()->rol != 'docente')
                                    <a href="{{ route('grupos.edit', $g->id) }}" class="btn btn-warning btn-sm">Editar</a>

                                    <form action="{{ route('grupos.destroy', $g->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>

                                    <a href="{{ route('grupos.addStudents', $g->id) }}" class="btn btn-success btn-sm">Agregar Estudiantes</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
