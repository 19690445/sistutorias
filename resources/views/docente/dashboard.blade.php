@extends('adminlte::page')

@section('title', 'Panel del Tutor')

@section('content_header')
    <h1 class="text-primary">Panel del Tutor</h1>
@stop

@section('content')
    <p>Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Has iniciado sesión como <strong>tutor</strong>.</p>

    {{-- Tarjetas de resumen --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalTutorados ?? 0 }}</h3>
                    <p>Tutorados Asignados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <a href="#" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalSesiones ?? 0 }}</h3>
                    <p>Sesiones de Tutoría</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <a href="#" class="small-box-footer">Registrar nueva <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalReportes ?? 0 }}</h3>
                    <p>Reportes Generados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="#" class="small-box-footer">Ver reportes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $tutoresActivos ?? 0 }}</h3>
                    <p>Tutores Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <a href="{{ route('tutores.index') }}" class="small-box-footer">Gestionar tutores <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Herramientas del Tutor --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-tools"></i> Herramientas del Tutor</h3>
        </div>

        <div class="card-body">
            <ul class="list-unstyled">
                <li class="mb-2">
                    <a href="{{ route('tutores.index') }}" class="text-primary">
                        <i class="fas fa-users"></i> Gestionar Tutores
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="text-primary">
                        <i class="fas fa-user-graduate"></i> Ver Tutorados Asignados
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="text-primary">
                        <i class="fas fa-book"></i> Registrar Seguimiento de Tutorías
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="text-primary">
                        <i class="fas fa-file-alt"></i> Generar Reportes
                    </a>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('footer')
    <p class="text-center text-muted">Sistema de Tutorías — Panel del Tutor</p>
@stop
