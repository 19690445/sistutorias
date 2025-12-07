@extends('adminlte::page')

@section('title', 'Registrar Estudiantes')

@section('content_header')
    <h1>Registrar Estudiantes</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Nuevo Estudiante</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tutorados.store') }}" method="POST">
            @csrf
         
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="matricula">Matrícula</label>
                    <input type="text" name="matricula" class="form-control" value="{{ old('matricula') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="curp">CURP</label>
                    <input type="text" name="curp" class="form-control" value="{{ old('curp') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="genero">Género</label>
                    <select name="genero" class="form-control">
                        <option value="">Selecciona</option>
                        <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="domicilio">Domicilio</label>
                    <input type="text" name="domicilio" class="form-control" value="{{ old('domicilio') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="telefono_celular">Teléfono Celular</label>
                    <input type="text" name="telefono_celular" class="form-control" value="{{ old('telefono_celular') }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="correo_institucional">Correo Institucional</label>
                    <input type="email" name="correo_institucional" class="form-control" value="{{ old('correo_institucional') }}">
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
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="semestre">Semestre</label>
                    <select name="semestre" class="form-control">
                        <option value="">Seleccione</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="estado">Estado</label>
                    <select name="estado" class="form-control">
                        <option value="">Selecciona</option>
                        <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="baja_temporal" {{ old('estado') == 'baja_temporal' ? 'selected' : '' }}>Baja Temporal</option>
                        <option value="baja_definitiva" {{ old('estado') == 'baja_definitiva' ? 'selected' : '' }}>Baja Definitiva</option>
                        <option value="egresado" {{ old('estado') == 'egresado' ? 'selected' : '' }}>Egresado</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_egreso">Fecha de Egreso</label>
                    <input type="date" name="fecha_egreso" class="form-control" value="{{ old('fecha_egreso') }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="{{ route('admin.tutorados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>
@stop
