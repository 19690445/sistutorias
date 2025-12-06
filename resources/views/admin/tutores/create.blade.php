@extends('adminlte::page')

@section('title', 'Agregar Tutor')

@section('content_header')
    <h1>Agregar Tutor</h1>
@stop

@section('content')
<form action="{{ route('tutores.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary">
        <div class="card-body">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
            </div>

            <div class="form-group">
                <label>CURP</label>
                <input type="text" name="curp" class="form-control" value="{{ old('curp') }}">
            </div>

            <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
            </div>

            <div class="form-group">
                <label>Sexo</label>
                <select name="sexo" class="form-control">
                    <option value="">Seleccione</option>
                    <option value="masculino" {{ old('sexo')=='masculino'?'selected':'' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo')=='femenino'?'selected':'' }}>Femenino</option>
                    <option value="otro" {{ old('sexo')=='otro'?'selected':'' }}>Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="correo_electronico" class="form-control" value="{{ old('correo_electronico') }}" required>
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
            </div>

            <div class="form-group">
                <label>Departamento</label>
                <input type="text" name="departamento" class="form-control" value="{{ old('departamento') }}">
            </div>

            <div class="form-group">
                <label>RFC</label>
                <input type="text" name="rfc" class="form-control" value="{{ old('rfc') }}">
            </div>

            <div class="form-group">
                <label>Nivel de estudios</label>
                <input type="text" name="nivel_estudios" class="form-control" value="{{ old('nivel_estudios') }}">
            </div>

            <div class="form-group">
                <label>Descripción de estudios</label>
                <textarea name="descripcion_estudios" class="form-control">{{ old('descripcion_estudios') }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto de perfil</label>
                <input type="file" name="foto_perfil" class="form-control">
            </div>

            <div class="form-group">
                <label>Estado</label>
                <select name="estado" class="form-control">
                    <option value="activo" {{ old('estado')=='activo'?'selected':'' }}>Activo</option>
                    <option value="inactivo" {{ old('estado')=='inactivo'?'selected':'' }}>Inactivo</option>
                </select>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('tutores.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>
@stop
