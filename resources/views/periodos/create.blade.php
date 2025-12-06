
@extends('adminlte::page')

@section('title', 'Crear Periodo')

@section('content_header')
    <h1>Crear Periodo</h1>
@stop

@section('content')
    <div class="container-fluid">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> ¡Error!</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $rolePrefix = auth()->user()->role->nombre; 
            $routeStore = $rolePrefix . '.periodos.store';
        @endphp

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Formulario de Periodo</h3>
            </div>

            <form action="{{ route($routeStore) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre_periodo">Nombre del Periodo</label>
                        <input type="text" name="nombre_periodo" id="nombre_periodo" class="form-control" value="{{ old('nombre_periodo') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="año_periodo">Año</label>
                        <input type="number" name="año_periodo" id="año_periodo" class="form-control" value="{{ old('año_periodo') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin">Fecha de Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Periodo</button>
                    <a href="{{ route($rolePrefix . '.periodos.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop
