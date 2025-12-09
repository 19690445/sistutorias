@extends('adminlte::page')

@section('title', 'Crear PAT')

@section('content_header')
    <h1>Crear PAT</h1>
@stop

@section('content')
<form action="{{ route('pats.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Actividad</label>
        <input type="text" name="actividad" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Tutor</label>
        <select name="tutores_id" class="form-control" required>
            <option value="">Seleccione un tutor</option>
            @foreach($tutores as $tutor)
                <option value="{{ $tutor->id }}">{{ $tutor->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Grupo</label>
        <select name="grupos_id" class="form-control" required>
            <option value="">Seleccione un grupo</option>
            @foreach($grupos as $grupo)
                <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Periodo</label>
        <select name="periodo_id" class="form-control" required>
            <option value="">Seleccione un periodo</option>
            @foreach($periodos as $periodo)
                <option value="{{ $periodo->id }}">{{ $periodo->nombre_periodo }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Guardar PAT</button>
</form>
@stop
