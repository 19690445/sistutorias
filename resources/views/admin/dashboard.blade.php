@extends('adminlte::page')

@section('title', 'Panel de Administración')

@section('content_header')
    <h1 class="text-primary">Panel de Administración</h1>
@stop

@section('content')
{{-- dump(Auth::user()) --}}
    <p>Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Has iniciado sesión como <strong>{{Auth::user()->role->nombre}}</strong>.</p>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Gestión del Sistema</h3>
        </div>
        <div class="card-body">
            <ul>
                <a href="{{ route('admin.tutorados.create') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i> Registrar Alumno
                </a>

                <a href="{{ route('admin.tutorados.index') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i> Ver Alumno Registrado
                </a>

                @can('gestionar-usuarios')
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i> Usuarios
                </a>
                @endcan

                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i> Crear Usuarios
                </a>
            </ul>
        </div>
    </div>
@stop

@section('footer')
    <p class="text-center">Sistema de Tutorías — Panel Administrador</p>
@stop
