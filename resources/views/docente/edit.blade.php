@extends('adminlte::page')

@section('title', 'Editar Tutor')

@section('content_header')
    <h1>Editar Docente</h1>
@stop

@section('content')
<form action="{{ route('tutores.update', $tutor->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Actualizar Datos del Docente</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tutor->nombre) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $tutor->apellidos) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>CURP</label>
                    <input type="text" name="curp" class="form-control" value="{{ old('curp', $tutor->curp) }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $tutor->fecha_nacimiento) }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="masculino" {{ old('sexo', $tutor->sexo)=='masculino'?'selected':'' }}>Masculino</option>
                        <option value="femenino" {{ old('sexo', $tutor->sexo)=='femenino'?'selected':'' }}>Femenino</option>
                        <option value="otro" {{ old('sexo', $tutor->sexo)=='otro'?'selected':'' }}>Otro</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $tutor->telefono) }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Correo electrónico</label>
                    <input type="email" name="correo_electronico" class="form-control" value="{{ old('correo_electronico', $tutor->correo_electronico) }}" required>
                </div>
            </div>

        
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Nueva contraseña (opcional)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Departamento</label>
                    <select name="departamento" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Ciencias" {{ old('departamento', $tutor->departamento)=='Ciencias'?'selected':'' }}>Ciencias</option>
                        <option value="Economico" {{ old('departamento', $tutor->departamento)=='Economico'?'selected':'' }}>Económico</option>
                        <option value="Administrativas" {{ old('departamento', $tutor->departamento)=='Administrativas'?'selected':'' }}>Administrativas</option>
                        <option value="Ciencias Basicas" {{ old('departamento', $tutor->departamento)=='Ciencias Basicas'?'selected':'' }}>Ciencias Básicas</option>
                        <option value="Sistemas y Computacion" {{ old('departamento', $tutor->departamento)=='Sistemas y Computacion'?'selected':'' }}>Sistemas y Computación</option>
                        <option value="Ingenierias" {{ old('departamento', $tutor->departamento)=='Ingenierias'?'selected':'' }}>Ingenierías</option>
                        <option value="Agronomia" {{ old('departamento', $tutor->departamento)=='Agronomia'?'selected':'' }}>Agronomía</option>
                        <option value="Ingeniera Industrial" {{ old('departamento', $tutor->departamento)=='Ingeniera Industrial'?'selected':'' }}>Ingeniería Industrial</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>RFC</label>
                    <input type="text" name="rfc" class="form-control" value="{{ old('rfc', $tutor->rfc) }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Nivel de estudios</label>
                    <select name="nivel_estudios" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Secundaria" {{ old('nivel_estudios', $tutor->nivel_estudios)=='Secundaria'?'selected':'' }}>Secundaria</option>
                        <option value="Preparatoria/Bachillerato" {{ old('nivel_estudios', $tutor->nivel_estudios)=='Preparatoria/Bachillerato'?'selected':'' }}>Preparatoria/Bachillerato</option>
                        <option value="Tecnico" {{ old('nivel_estudios', $tutor->nivel_estudios)=='Tecnico'?'selected':'' }}>Técnico</option>
                        <option value="Licenciatura" {{ old('nivel_estudios', $tutor->nivel_estudios)=='Licenciatura'?'selected':'' }}>Licenciatura</option>
                        <option value="Ingeniería" {{ old('nivel_estudios', $tutor->nivel_estudios)=='Ingeniería'?'selected':'' }}>Ingeniería</option>
                        <option value="Maestría" {{ old('nivel_estudios', $tutor->nivel_estudios)=='Maestría'?'selected':'' }}>Maestría</option>
                        <option value="Doctorado" {{ old('nivel_estudios', $tutor->nivel_estudios)=='Doctorado'?'selected':'' }}>Doctorado</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Estado</label>
                    <select name="estado" class="form-control">
                        <option value="activo" {{ old('estado', $tutor->estado)=='activo'?'selected':'' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $tutor->estado)=='inactivo'?'selected':'' }}>Inactivo</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label>Descripción de estudios</label>
                    <textarea name="descripcion_estudios" class="form-control">{{ old('descripcion_estudios', $tutor->descripcion_estudios) }}</textarea>
                </div>

                <div class="form-group col-md-4">
                    <label>Foto de perfil</label>
                    <input type="file" name="foto_perfil" class="form-control" id="foto_perfil">

                    <img id="preview"
                         src="{{ $tutor->foto_perfil ? asset('storage/'.$tutor->foto_perfil) : asset('img/default.png') }}"
                         class="img-thumbnail mt-2"
                         width="150">
                </div>
            </div>

        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-warning">Actualizar</button>
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
