
@extends('adminlte::page')

@section('title', 'Canalizaciones')

@section('content_header')
<h1>Canalizaciones</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(auth()->user()->hasRole('docente'))
            <a href="{{ route('canalizaciones.create') }}" class="btn btn-primary mb-3">Nueva Canalización</a>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Tipo de Atención</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($canalizaciones as $canal)
                <tr>
                    <td>{{ $canal->individuale->estudiante->nombre ?? '' }} {{ $canal->individuale->estudiante->apellidos ?? '' }}</td>
                    <td>{{ ucfirst($canal->tipo_atencion) }}</td>
                    <td>{{ ucfirst($canal->estado) }}</td>
                    <td>
                        <a href="{{ route('canalizaciones.show', $canal->id) }}" class="btn btn-info btn-sm">Ver</a>

                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('coordinador'))
                            <a href="{{ route('canalizaciones.edit', $canal->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        @endif

                        @if(auth()->user()->hasRole('admin'))
                            <form action="{{ route('canalizaciones.destroy', $canal->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('¿Estás seguro de eliminar esta canalización?')">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
