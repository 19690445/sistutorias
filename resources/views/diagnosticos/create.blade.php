@extends('adminlte::page')

@section('title', 'Nuevo Diagnóstico')

@section('content_header')
    <h1 class="text-success"><i class="fas fa-plus-circle"></i> Crear Diagnóstico</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('diagnosticos.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="grupos_id" class="form-label">Grupo</label>
                        <select name="grupos_id" id="grupos_id" class="form-control" required>
                            <option value="">Seleccione un grupo</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }} - {{ $grupo->carrera }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="periodo_id" class="form-label">Periodo</label>
                        <select name="periodo_id" id="periodo_id" class="form-control" required>
                            <option value="">Seleccione un periodo</option>
                            @foreach(\App\Models\Periodo::all() as $periodo)
                                <option value="{{ $periodo->id }}" {{ old('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                {{ $periodo->nombre_periodo }} - {{ $periodo->año_periodo }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="problemarios" class="form-label">Problemarios</label>
                    <textarea name="problemarios" id="problemarios" class="form-control" rows="3" placeholder="Describe las problemáticas identificadas..." required></textarea>
                </div>

                <div class="mb-3">
                    <label for="objetivos" class="form-label">Objetivos</label>
                    <textarea name="objetivos" id="objetivos" class="form-control" rows="3" placeholder="Escribe los objetivos del diagnóstico..." required></textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_realizacion" class="form-label">Fecha de Realizacion</label>
                    <input type="date" name="fecha_realizacion" id="fecha_realizacion" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Diagnóstico
                </button>

                <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </form>
        </div>
    </div>
@stop
