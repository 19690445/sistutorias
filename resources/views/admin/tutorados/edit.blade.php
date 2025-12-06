@extends('adminlte::page')

@section('title', 'Editar Tutorado')

@section('content_header')
    <h1 class="text-center">Editar Tutorado</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-user-edit"></i> Modificar Información</h3>

            <a href="{{ auth()->user()->role->nombre === 'admin' 
                ? route('admin.tutorados.index') 
                : route('coordinador.tutorados.index') }}" 
                class="btn btn-light text-warning">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>

        <div class="card-body">
       
            <form action="{{ auth()->user()->role->nombre === 'admin' 
                ? route('admin.tutorados.update', $tutorado->id) 
                : route('coordinador.tutorados.update', $tutorado->id) }}" 
                method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" name="matricula" class="form-control" 
                            value="{{ old('matricula', $tutorado->matricula) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="correo_institucional" class="form-label">Correo institucional</label>
                        <input type="email" name="correo_institucional" class="form-control" 
                            value="{{ old('correo_institucional', $tutorado->correo_institucional) }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" 
                            value="{{ old('nombre', $tutorado->nombre) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" 
                            value="{{ old('apellidos', $tutorado->apellidos) }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="carrera" class="form-label">Carrera</label>
                        <input type="text" name="carrera" class="form-control" 
                            value="{{ old('carrera', $tutorado->carrera) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="semestre" class="form-label">Semestre</label>
                        <input type="number" name="semestre" class="form-control" 
                            min="1" max="12" value="{{ old('semestre', $tutorado->semestre) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" class="form-control" required>
                        <option value="activo" {{ $tutorado->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="baja_temporal" {{ $tutorado->estado == 'baja_temporal' ? 'selected' : '' }}>Baja Temporal</option>
                        <option value="baja_definitiva" {{ $tutorado->estado == 'baja_definitiva' ? 'selected' : '' }}>Baja Definitiva</option>
                        <option value="egresado" {{ $tutorado->estado == 'egresado' ? 'selected' : '' }}>Egresado</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
