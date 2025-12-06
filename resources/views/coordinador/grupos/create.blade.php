@extends('adminlte::page')

@section('title', 'Crear Grupo')

@section('content_header')
    <h1 class="text-primary"><i class="fas fa-plus-circle"></i> Crear Nuevo Grupo</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('coordinador.grupos.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Clave del Grupo</label>
                    <input type="text" name="clave_grupo" class="form-control" value="{{ old('clave_grupo') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Nombre del Grupo</label>
                    <input type="text" name="nombre_grupo" class="form-control" value="{{ old('nombre_grupo') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Docente</label>
                    <select name="tutores_id" class="form-control" required>
                        <option value="">Seleccione un tutor</option>
                        @foreach($tutores as $t)
                            <option value="{{ $t->id }}" {{ old('tutores_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->nombre }} {{ $t->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Periodo</label>
                    <select name="periodo_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($periodos as $p)
                            <option value="{{ $p->id }}" {{ old('periodo_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nombre_periodo }} - {{ $p->año_periodo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Carrera</label>
                    <input type="text" name="carrera" class="form-control" value="{{ old('carrera') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Semestre</label>
                    <input type="number" name="semestre" class="form-control" value="{{ old('semestre') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Aula</label>
                    <input type="text" name="aula" class="form-control" value="{{ old('aula') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Horario</label>
                    <input type="text" name="horario" class="form-control" value="{{ old('horario') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Capacidad del Salón</label>
                    <input type="number" name="capacidad_salon" class="form-control" value="{{ old('capacidad_salon') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Modalidad</label>
                    <select name="modalidad" class="form-control" required>
                        <option value="presencial" {{ old('modalidad') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="virtual" {{ old('modalidad') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                        <option value="mixta" {{ old('modalidad') == 'mixta' ? 'selected' : '' }}>Mixta</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Turno</label>
                    <select name="turno" class="form-control" required>
                        <option value="matutino" {{ old('turno') == 'matutino' ? 'selected' : '' }}>Matutino</option>
                        <option value="intermedio" {{ old('turno') == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="vespertino" {{ old('turno') == 'vespertino' ? 'selected' : '' }}>Vespertino</option>
                    </select>
                </div>

            </div>

            <div class="mt-3">
                <button class="btn btn-success"><i class="fas fa-save"></i> Guardar Grupo</button>
                <a href="{{ route('coordinador.grupos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>

    </div>
</div>

@stop
