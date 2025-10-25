@extends('adminlte::page')

@section('title', 'Panel del Coordinador')

@section('content_header')
    <h1 class="text-warning">Panel del Coordinador</h1>
@stop

@section('content')
    <p>Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Has iniciado sesión como <strong>Coordinador</strong>.</p>

    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h3 class="card-title">Herramientas del Coordinador</h3>
        </div>
        <div class="card-body">
            <ul>
                <a href="{{ route('coordinador.tutorados.index') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i> Ver Tutorados
                </a>
                <a href="{{ route('coordinador.tutorados.index') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i> Ver Tutorados
                </a>

            </ul>
        </div>
    </div>
@stop

@section('footer')
    <p class="text-center">Sistema de Tutorías — Panel Coordinador</p>
@stop
