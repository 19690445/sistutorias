@extends('adminlte::page')

@section('title', 'Nuevo Grupo')

@section('content_header')
    <h1>Crear Grupo</h1>
    <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Regresar</a>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Error!</strong> Hubo algunos problemas con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('grupos.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="clave_grupo">Clave del Grupo</label>
                        <input type="text" name="clave_grupo" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nombre_grupo">Nombre del Grupo</label>
                        <input type="text" name="nombre_grupo" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tutores_id">Tutor</label>
                        <select name="tutores_id" class="form-control" required>
                            <option value="">Selecciona un tutor</option>
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->id }}">{{ $tutor->nombre }} {{ $tutor->apellido }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="periodo_id">Periodo</label>
                        <select name="periodo_id" class="form-control" required>
                            <option value="">Selecciona un periodo</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}">{{ $periodo->nombre_periodo }} - {{ $periodo->año_periodo }}</option>
                            @endforeach
                        </select>
                    </div>

                <div class="form-group col-md-4">
                    <label for="carrera">Carrera</label>
                    <select name="carrera" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="INGENIERÍA EN SISTEMAS COMPUTACIONALES" {{ old('carrera') == 'INGENIERÍA EN SISTEMAS COMPUTACIONALES' ? 'selected' : '' }}>INGENIERÍA EN SISTEMAS COMPUTACIONALES</option>
                        <option value="INGENIERÍA INDUSTRIAL" {{ old('carrera') == 'INGENIERÍA INDUSTRIAL' ? 'selected' : '' }}>INGENIERÍA INDUSTRIAL</option>
                        <option value="INGENIERÍA EN GESTIÓN EMPRESARIAL" {{ old('carrera') == 'INGENIERÍA EN GESTIÓN EMPRESARIAL' ? 'selected' : '' }}>INGENIERÍA EN GESTIÓN EMPRESARIAL</option>
                        <option value="INGENIERÍA AMBIENTAL" {{ old('carrera') == 'INGENIERÍA AMBIENTAL' ? 'selected' : '' }}>INGENIERÍA AMBIENTAL</option>
                        <option value="INGENIERÍA EN AGRONOMÍA" {{ old('carrera') == 'INGENIERÍA EN AGRONOMÍA' ? 'selected' : '' }}>INGENIERÍA EN AGRONOMÍA</option>
                        <option value="INGENIERÍA EN INTELIGENCIA ARTIFICIAL" {{ old('carrera') == 'INGENIERÍA EN INTELIGENCIA ARTIFICIAL' ? 'selected' : '' }}>INGENIERÍA EN INTELIGENCIA ARTIFICIAL</option>
                        <option value="INGENIERÍA EN ALIMENTARIAS" {{ old('carrera') == 'INGENIERÍA EN ALIMENTARIAS' ? 'selected' : '' }}>INGENIERÍA EN ALIMENTARIAS</option>
                        <option value="INGENIERÍA EN DESARROLLO DE APLICACIONES" {{ old('carrera') == 'INGENIERÍA EN DESARROLLO DE APLICACIONES' ? 'selected' : '' }}>INGENIERÍA EN DESARROLLO DE APLICACIONES</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="semestre">Semestre</label>
                    <select name="semestre" class="form-control">
                        <option value="">Seleccione</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                        <label for="modalidad">Modalidad</label>
                        <select name="modalidad" class="form-control">
                            <option value="presencial">Presencial</option>
                            <option value="virtual">Virtual</option>
                            <option value="mixta">Mixta</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="aula">Aula</label>
                        <input type="text" name="aula" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="horario">Horario</label>
                        <input type="text" name="horario" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="capacidad_salon">Capacidad del Salón</label>
                        <input type="number" name="capacidad_salon" class="form-control" min="1">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="turno">Turno</label>
                        <select name="turno" class="form-control">
                            <option value="matutino">Matutino</option>
                            <option value="intermedio">Intermedio</option>
                            <option value="vespertino">Vespertino</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-2">Guardar Grupo</button>
            </form>
        </div>
    </div>
@stop
