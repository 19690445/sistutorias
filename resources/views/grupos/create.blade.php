@extends('adminlte::page')

@section('title', 'Crear Grupo')

@section('content_header')
    <h1>Crear Grupo</h1>
@stop

@section('content')
    <form action="{{ route('grupos.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Clave del Grupo</label>
            <input type="text" name="clave_grupo" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nombre del Grupo</label>
            <input type="text" name="nombre_grupo" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Tutor</label>
            <select name="tutores_id" class="form-control" required>
                <option value="">Selecciona un tutor</option>
                @foreach($tutores as $tutor)
                    <option value="{{ $tutor->id }}">{{ $tutor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Periodo</label>
            <select name="periodo_id" class="form-control" required>
                <option value="">Selecciona un periodo</option>
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Carrera</label>
            <input type="text" name="carrera" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Semestre</label>
            <input type="number" name="semestre" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Aula</label>
            <input type="text" name="aula" class="form-control">
        </div>

        <div class="form-group">
            <label>Horario</label>
            <input type="text" name="horario" class="form-control">
        </div>

        <div class="form-group">
            <label>Capacidad del salón</label>
            <input type="number" name="capacidad_salon" class="form-control">
        </div>

        <div class="form-group">
            <label>Modalidad</label>
            <select name="modalidad" class="form-control">
                <option value="presencial">Presencial</option>
                <option value="virtual">Virtual</option>
                <option value="mixta">Mixta</option>
            </select>
        </div>

        <div class="form-group">
            <label>Turno</label>
            <select name="turno" class="form-control">
                <option value="matutino">Matutino</option>
                <option value="intermedio">Intermedio</option>
                <option value="vespertino">Vespertino</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Crear Grupo</button>
    </form>
@stop
