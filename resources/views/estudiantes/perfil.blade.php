@extends('adminlte::page')
@section('title','Mi Perfil')

@section('content_header')
<h1>Mi información</h1>
@stop

@section('content')
<form action="{{ route('tutorado.update', $estudiante->id) }}" method="POST">
    @csrf @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Matrícula</label>
                <input type="text" class="form-control" value="{{ $estudiante->matricula }}" readonly>
            </div>

            <div class="form-group">
                <label>Nombre</label>
                <input name="nombre" class="form-control" value="{{ $estudiante->nombre }}">
            </div>

            <div class="form-group">
                <label>Apellidos</label>
                <input name="apellidos" class="form-control" value="{{ $estudiante->apellidos }}">
            </div>

            <div class="form-group">
                <label>Correo</label>
                <input class="form-control" value="{{ $estudiante->correo_institucional }}" readonly>
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input name="telefono_celular" class="form-control" value="{{ $estudiante->telefono_celular }}">
            </div>

            <button class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar
            </button>
        </div>
    </div>
</form>
@stop
