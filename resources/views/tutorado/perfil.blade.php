@extends('adminlte::page')

@section('title', 'Mi Perfil')

@section('content_header')
    <h1>Mi Perfil</h1>
@stop

@section('content')
<div class="row">
  
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <img class="profile-user-img img-fluid img-circle mb-3"
                     src="{{ $tutorado->foto ? asset('storage/' . $tutorado->foto) : asset('img/default-user.png') }}"
                     alt="Foto de {{ $tutorado->nombre }}">

                <h3 class="profile-username text-center">{{ $tutorado->nombre }} {{ $tutorado->apellidos }}</h3>
                <p class="text-muted text-center">{{ $tutorado->carrera }} - Semestre {{ $tutorado->semestre }}</p>

                <ul class="list-group list-group-unbordered mb-3 text-left">
                    <li class="list-group-item"><b>Matrícula:</b> {{ $tutorado->matricula }}</li>
                    <li class="list-group-item"><b>CURP:</b> {{ $tutorado->curp }}</li>
                    <li class="list-group-item"><b>Género:</b> {{ ucfirst($tutorado->genero) }}</li>
                    <li class="list-group-item"><b>Fecha de Nacimiento:</b> {{ $tutorado->fecha_nacimiento }}</li>
                    <li class="list-group-item"><b>Estado:</b> {{ ucfirst($tutorado->estado) }}</li>
                    <li class="list-group-item"><b>Fecha de Ingreso:</b> {{ $tutorado->fecha_ingreso }}</li>
                    @if($tutorado->fecha_egreso)
                        <li class="list-group-item"><b>Fecha de Egreso:</b> {{ $tutorado->fecha_egreso }}</li>
                    @endif
                </ul>

                <a href="{{ route('tutorado.editPerfil') }}" class="btn btn-primary btn-block">
                    <b>Editar Perfil</b>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Datos de Contacto y Académicos</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6"><b>Domicilio:</b> {{ $tutorado->domicilio }}</div>
                    <div class="col-md-6"><b>Teléfono Celular:</b> {{ $tutorado->telefono_celular }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><b>Correo Institucional:</b> {{ $tutorado->correo_institucional }}</div>
                    <div class="col-md-6"><b>Carrera:</b> {{ $tutorado->carrera }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><b>Semestre:</b> {{ $tutorado->semestre }}</div>
                    <div class="col-md-6"><b>Fecha de Nacimiento:</b> {{ $tutorado->fecha_nacimiento }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
