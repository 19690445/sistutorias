@extends('adminlte::page')

@section('title', 'Detalles del Tutorado')

@section('content_header')
    <h1 class="text-center">Detalles del Tutorado</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-user"></i> Información del Tutorado</h3>
            <a href="{{ route('admin.tutorados.index') }}" class="btn btn-light text-info">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Matrícula:</strong> {{ $tutorado->matricula }}
                </div>
                <div class="col-md-6">
                    <strong>Correo institucional:</strong> {{ $tutorado->correo_institucional }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nombre:</strong> {{ $tutorado->nombre }}
                </div>
                <div class="col-md-6">
                    <strong>Apellidos:</strong> {{ $tutorado->apellidos }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Carrera:</strong> {{ $tutorado->carrera }}
                </div>
                <div class="col-md-6">
                    <strong>Semestre:</strong> {{ $tutorado->semestre }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Estado:</strong>
                    @if ($tutorado->estado == 'activo')
                        <span class="badge bg-success">Activo</span>
                    @elseif($tutorado->estado == 'baja_temporal')
                        <span class="badge bg-warning text-dark">Baja Temporal</span>
                    @elseif($tutorado->estado == 'baja_definitiva')
                        <span class="badge bg-danger">Baja Definitiva</span>
                    @else
                        <span class="badge bg-secondary">Egresado</span>
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Creado el:</strong> {{ $tutorado->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('admin.tutorados.edit', $tutorado->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
    </div>
@stop
