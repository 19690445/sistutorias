@extends('adminlte::page')

@section('title', 'PATS')

@section('content_header')
    <h1>PATS</h1>
@stop

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario para agregar PAT --}}
    <div class="card mb-4">
        <div class="card-header">Agregar Nuevo PAT</div>
        <div class="card-body">
            <form action="{{ route('pats.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="actividad" class="form-label">Actividad</label>
                        <input type="text" name="actividad" id="actividad" class="form-control" required>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="tutores_id" class="form-label">Tutor</label>
                        <select name="tutores_id" id="tutores_id" class="form-control" required>
                            <option value="">Selecciona un tutor</option>
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->id }}">{{ $tutor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="grupos_id" class="form-label">Grupo</label>
                        <select name="grupos_id" id="grupos_id" class="form-control" required>
                            <option value="">Selecciona un grupo</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Agregar PAT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de PATS --}}
    <div class="card">
        <div class="card-header">Lista de PATS</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Actividad</th>
                        <th>Tutor</th>
                        <th>Grupo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pats as $pat)
                    <tr>
                        <td>{{ $pat->id }}</td>
                        <td>{{ $pat->actividad }}</td>
                        <td>{{ $pat->tutor->nombre ?? 'N/A' }}</td>
                        <td>{{ $pat->grupo->nombre_grupo ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('pats.edit', $pat->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('pats.destroy', $pat->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Seguro que quieres eliminar este PAT?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($pats->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay PATs registrados.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@stop
