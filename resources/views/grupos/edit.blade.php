@extends('adminlte::page')

@section('title', 'Editar Grupo')

@section('content_header')
    <h1>Editar Grupo</h1>
@stop

@section('content')
    <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Clave del Grupo</label>
            <input type="text" name="clave_grupo" class="form-control" value="{{ $grupo->clave_grupo }}" required>
        </div>

        <div class="form-group">
            <label>Nombre del Grupo</label>
            <input type="text" name="nombre_grupo" class="form-control" value="{{ $grupo->nombre_grupo }}" required>
        </div>

        <div class="form-group">
            <label>Tutor</label>
            <select name="tutores_id" class="form-control" required>
                @foreach($tutores as $tutor)
                    <option value="{{ $tutor->id }}" {{ $grupo->tutores_id == $tutor->id ? 'selected' : '' }}>{{ $tutor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Periodo</label>
            <select name="periodo_id" class="form-control" required>
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo->id }}" {{ $grupo->periodo_id == $periodo->id ? 'selected' : '' }}>{{ $periodo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Carrera</label>
            <input type="text" name="carrera" class="form-control" value="{{ $grupo->carrera }}" required>
        </div>

        <div class="form-group">
            <label>Semestre</label>
            <input type="number" name="semestre" class="form-control" value="{{ $grupo->semestre }}" required>
        </div>

        <div class="form-group">
            <label>Aula</label>
            <input type="text" name="aula" class="form-control" value="{{ $grupo->aula }}">
        </div>

        <div class="form-group">
            <label>Horario</label>
            <input type="text" name="horario" class="form-control" value="{{ $grupo->horario }}">
        </div>

        <div class="form-group">
            <label>Capacidad del salón</label>
            <input type="number" name="capacidad_salon" class="form-control" value="{{ $grupo->capacidad_salon }}">
        </div>

        <div class="form-group">
            <label>Modalidad</label>
            <select name="modalidad" class="form-control">
                <option value="presencial" {{ $grupo->modalidad == 'presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="virtual" {{ $grupo->modalidad == 'virtual' ? 'selected' : '' }}>Virtual</option>
                <option value="mixta" {{ $grupo->modalidad == 'mixta' ? 'selected' : '' }}>Mixta</option>
            </select>
        </div>

        <div class="form-group">
            <label>Turno</label>
            <select name="turno" class="form-control">
                <option value="matutino" {{ $grupo->turno == 'matutino' ? 'selected' : '' }}>Matutino</option>
                <option value="intermedio" {{ $grupo->turno == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                <option value="vespertino" {{ $grupo->turno == 'vespertino' ? 'selected' : '' }}>Vespertino</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Actualizar Grupo</button>
    </form>
@stop
