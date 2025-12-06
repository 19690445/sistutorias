@extends('adminlte::page')

@section('title', 'Panel del Estudiante')

@section('content_header')
    <h1 class="text-success">Panel del Estudiante</h1>
@stop

@section('content')
    <p>Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Aquí puedes ver información de tu tutor asignado:</p>

    @if($tutor)
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h3 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Tutor Asignado</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nombre:</strong> {{ $tutor->nombre }} {{ $tutor->apellidos }}</li>
                    <li class="list-group-item"><strong>Correo:</strong> {{ $tutor->correo_electronico }}</li>
                    <li class="list-group-item"><strong>Departamento:</strong> {{ $tutor->departamento }}</li>
                    <li class="list-group-item"><strong>Sexo:</strong> {{ ucfirst($tutor->sexo) }}</li>
                    <li class="list-group-item"><strong>Fecha de nacimiento:</strong> {{ $tutor->fecha_nacimiento }}</li>
                    <li class="list-group-item"><strong>Estado:</strong> {{ ucfirst($tutor->estado) }}</li>
                </ul>
            </div>
        </div>
    @else
        <div class="alert alert-warning">Aún no tienes un tutor asignado.</div>
    @endif
@stop

@section('footer')
    <p class="text-center text-muted">Sistema de Tutorías — Panel del Estudiante</p>
@stop
