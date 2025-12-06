@extends('adminlte::page')

@section('title', 'Mi Perfil')

@section('content_header')
    <h1 class="text-primary"><i class="fas fa-user-circle"></i> Mi Perfil</h1>
@stop

@section('content')

<div class="row">

    <!-- Foto de Perfil -->
    <div class="col-md-4">
        <div class="card card-primary card-outline shadow-lg">
            <div class="card-body box-profile text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ $tutor->foto_perfil ? asset('storage/' . $tutor->foto_perfil) : asset('img/default-avatar.png') }}"
                     alt="Foto de Perfil">

                <h3 class="profile-username text-center mt-3">{{ $tutor->nombre }} {{ $tutor->apellidos }}</h3>
                <p class="text-muted text-center">{{ $tutor->departamento ?? 'Docente' }}</p>

                <form action="{{ route('tutores.actualizarPerfil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mt-3">
                        <label for="foto_perfil">Cambiar Foto</label>
                        <input type="file" name="foto_perfil" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success btn-block mt-2"><i class="fas fa-save"></i> Guardar Foto</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Información Personal -->
    <div class="col-md-8">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Información Personal</h3>
            </div>
            <div class="card-body">

                <form action="{{ route('tutores.actualizarPerfil') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tutor->nombre) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $tutor->apellidos) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>CURP</label>
                            <input type="text" name="curp" class="form-control" value="{{ old('curp', $tutor->curp) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>RFC</label>
                            <input type="text" name="rfc" class="form-control" value="{{ old('rfc', $tutor->rfc) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $tutor->fecha_nacimiento) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Sexo</label>
                            <select name="sexo" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="masculino" {{ old('sexo', $tutor->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('sexo', $tutor->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('sexo', $tutor->sexo) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Correo Electrónico</label>
                            <input type="email" name="correo_electronico" class="form-control" value="{{ old('correo_electronico', $tutor->correo_electronico) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $tutor->telefono) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Departamento</label>
                            <input type="text" name="departamento" class="form-control" value="{{ old('departamento', $tutor->departamento) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nivel de Estudios</label>
                            <input type="text" name="nivel_estudios" class="form-control" value="{{ old('nivel_estudios', $tutor->nivel_estudios) }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Descripción de Estudios</label>
                            <textarea name="descripcion_estudios" class="form-control" rows="4">{{ old('descripcion_estudios', $tutor->descripcion_estudios) }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Estado</label>
                            <select name="estado" class="form-control">
                                <option value="activo" {{ old('estado', $tutor->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $tutor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success"><i class="fas fa-save"></i> Guardar Cambios</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

@stop
