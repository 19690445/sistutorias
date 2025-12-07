@extends('adminlte::page')

@section('title', 'Agregar Tutor')

@section('content_header')
    <h1>Agregar Tutor</h1>
@stop

@section('content')
<form action="{{ route('tutores.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Datos del Tutor</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Nombre y Apellidos -->
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                </div>
            </div>

            <div class="row">
                <!-- CURP y Fecha -->
                <div class="form-group col-md-6">
                    <label>CURP</label>
                    <input type="text" name="curp" class="form-control" value="{{ old('curp') }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                </div>
            </div>

            <div class="row">
                <!-- Sexo y Teléfono -->
                <div class="form-group col-md-6">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="masculino" {{ old('sexo')=='masculino'?'selected':'' }}>Masculino</option>
                        <option value="femenino" {{ old('sexo')=='femenino'?'selected':'' }}>Femenino</option>
                        <option value="otro" {{ old('sexo')=='otro'?'selected':'' }}>Otro</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                </div>
            </div>

            <div class="row">
                <!-- Correo y Contraseña -->
                <div class="form-group col-md-6">
                    <label>Correo electrónico</label>
                    <input type="email" name="correo_electronico" class="form-control" value="{{ old('correo_electronico') }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <!-- Departamento y RFC -->
                <div class="form-group col-md-6">
                    <label>Departamento</label>
                    <select name="departamento" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Ciencias">Ciencias</option>
                        <option value="Economico">Económico</option>
                        <option value="Administrativas">Administrativas</option>
                        <option value="Ciencias Basicas">Ciencias Básicas</option>
                        <option value="Sistemas y Computacion">Sistemas y Computación</option>
                        <option value="Ingenierias">Ingenierías</option>
                        <option value="Agronomia">Agronomía</option>
                        <option value="Ingeniera Industrial">Ingeniería Industrial</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>RFC</label>
                    <input type="text" name="rfc" class="form-control" value="{{ old('rfc') }}">
                </div>
            </div>

            <div class="row">
                <!-- Nivel de estudios y Estado -->
                <div class="form-group col-md-6">
                    <label>Nivel de estudios</label>
                    <select name="nivel_estudios" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Secundaria">Secundaria</option>
                        <option value="Preparatoria/Bachillerato">Preparatoria/Bachillerato</option>
                        <option value="Tecnico">Técnico</option>
                        <option value="Licenciatura">Licenciatura</option>
                        <option value="Ingeniería">Ingeniería</option>
                        <option value="Maestría">Maestría</option>
                        <option value="Doctorado">Doctorado</option>
                        <option value="Postdoctorado">Postdoctorado</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Estado</label>
                    <select name="estado" class="form-control">
                        <option value="activo" {{ old('estado')=='activo'?'selected':'' }}>Activo</option>
                        <option value="inactivo" {{ old('estado')=='inactivo'?'selected':'' }}>Inactivo</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Descripción y Foto -->
                <div class="form-group col-md-8">
                    <label>Descripción de estudios</label>
                    <textarea name="descripcion_estudios" class="form-control">{{ old('descripcion_estudios') }}</textarea>
                </div>
                <div class="form-group col-md-4">
                    <label>Foto de perfil</label>
                    <input type="file" name="foto_perfil" class="form-control" id="foto_perfil">
                    <!-- Preview -->
                    <img id="preview" src="{{ asset('img/default.png') }}" alt="Vista previa" class="img-thumbnail mt-2" width="150">
                </div>
            </div>

        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('tutores.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>
@stop

@section('js')
<script>
    
    document.getElementById('foto_perfil').addEventListener('change', function(event){
        const [file] = this.files;
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    });
</script>
@stop
