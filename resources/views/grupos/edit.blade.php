@extends('adminlte::page')

@section('title', 'Editar Grupo')

@section('content_header')
    <h1>Editar Grupo</h1>
    <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Regresar</a>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="clave_grupo" class="form-label">Clave del Grupo</label>
                        <input type="text" name="clave_grupo" class="form-control" value="{{ old('clave_grupo', $grupo->clave_grupo) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nombre_grupo" class="form-label">Nombre del Grupo</label>
                        <input type="text" name="nombre_grupo" class="form-control" value="{{ old('nombre_grupo', $grupo->nombre_grupo) }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tutores_id" class="form-label">Tutor</label>
                        <select name="tutores_id" class="form-control" required>
                            <option value="">-- Seleccionar Tutor --</option>
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->id }}" {{ $grupo->tutores_id == $tutor->id ? 'selected' : '' }}>
                                    {{ $tutor->nombre }} {{ $tutor->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="periodo_id" class="form-label">Periodo</label>
                        <select name="periodo_id" class="form-control" required>
                            <option value="">-- Seleccionar Periodo --</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ $grupo->periodo_id == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre_periodo }} - {{ $periodo->año_periodo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="carrera" class="form-label">Carrera</label>
                        <input type="text" name="carrera" class="form-control" value="{{ old('carrera', $grupo->carrera) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="semestre" class="form-label">Semestre</label>
                        <input type="number" name="semestre" class="form-control" value="{{ old('semestre', $grupo->semestre) }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="aula" class="form-label">Aula</label>
                        <input type="text" name="aula" class="form-control" value="{{ old('aula', $grupo->aula) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="horario" class="form-label">Horario</label>
                        <input type="text" name="horario" class="form-control" value="{{ old('horario', $grupo->horario) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="capacidad_salon" class="form-label">Capacidad del Salón</label>
                        <input type="number" name="capacidad_salon" class="form-control" value="{{ old('capacidad_salon', $grupo->capacidad_salon) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="modalidad" class="form-label">Modalidad</label>
                        <select name="modalidad" class="form-control">
                            <option value="presencial" {{ $grupo->modalidad == 'presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="virtual" {{ $grupo->modalidad == 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="mixta" {{ $grupo->modalidad == 'mixta' ? 'selected' : '' }}>Mixta</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="turno" class="form-label">Turno</label>
                        <select name="turno" class="form-control">
                            <option value="matutino" {{ $grupo->turno == 'matutino' ? 'selected' : '' }}>Matutino</option>
                            <option value="intermedio" {{ $grupo->turno == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                            <option value="vespertino" {{ $grupo->turno == 'vespertino' ? 'selected' : '' }}>Vespertino</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar Grupo</button>
            </form>
        </div>
    </div>
@stop
