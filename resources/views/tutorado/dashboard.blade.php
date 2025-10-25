@extends('adminlte::page')

@section('title', 'Panel del Tutorado')

@section('content_header')
    <h1>Bienvenido, {{ Auth::user()->name }}</h1>
@stop

@section('content')
    @if(!$tutorado)
        <div class="alert alert-warning">
            <strong>Atención:</strong> No se encontró tu información como estudiante.
            <br>Por favor, contacta al coordinador o administrador para que te registre.
        </div>
    @else
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Información Personal</h4>
            </div>
            <div class="card-body">
                <p><strong>Matrícula:</strong> {{ $tutorado->matricula }}</p>
                <p><strong>Nombre:</strong> {{ $tutorado->nombre }} {{ $tutorado->apellidos }}</p>
                <p><strong>CURP:</strong> {{ $tutorado->curp ?? 'No registrada' }}</p>
                <p><strong>Fecha de Nacimiento:</strong> {{ $tutorado->fecha_nacimiento ?? 'No registrada' }}</p>
                <p><strong>Género:</strong> {{ ucfirst($tutorado->genero) ?? 'No especificado' }}</p>
                <p><strong>Correo Institucional:</strong> {{ $tutorado->correo_institucional }}</p>
                <p><strong>Teléfono Celular:</strong> {{ $tutorado->telefono_celular ?? 'No registrado' }}</p>
                <p><strong>Domicilio:</strong> {{ $tutorado->domicilio ?? 'No registrado' }}</p>
                <p><strong>Carrera:</strong> {{ $tutorado->carrera ?? 'No registrada' }}</p>
                <p><strong>Semestre:</strong> {{ $tutorado->semestre ?? 'No registrado' }}</p>
                <p><strong>Estado:</strong>
                    <span class="badge bg-success">{{ ucfirst($tutorado->estado) }}</span>
                </p>
                <p><strong>Fecha de Ingreso:</strong> {{ $tutorado->fecha_ingreso ?? 'No registrada' }}</p>
                <p><strong>Fecha de Egreso:</strong> {{ $tutorado->fecha_egreso ?? 'No registrada' }}</p>
            </div>
        </div>
    @endif
@stop
