@extends('adminlte::page')

@section('title', 'Detalle del Diagnóstico')

@section('content_header')
    <h1 class="text-primary"><i class="fas fa-file-medical"></i> Detalle del Diagnóstico</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Información del Diagnóstico</h3>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Grupo:</strong> {{ $diagnostico->grupo->nombre_grupo ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                    <strong>Periodo:</strong> {{ $diagnostico->periodo->nombre ?? 'N/A' }}
                </div>
            </div>

            <div class="mb-3">
                <strong>Problemarios:</strong>
                <p class="border p-2 bg-light">{{ $diagnostico->problemarios ?? 'Sin datos' }}</p>
            </div>

            <div class="mb-3">
                <strong>Objetivos:</strong>
                <p class="border p-2 bg-light">{{ $diagnostico->objetivos ?? 'Sin datos' }}</p>
            </div>

            <div class="mb-3">
                <strong>Fecha de Realización:</strong> {{ $diagnostico->fecha_realizacion ?? 'No registrada' }}
            </div>

            <div class="mb-3">
                <strong>Estado:</strong>
                <span class="badge 
                    @if($diagnostico->estado == 'pendiente') bg-warning 
                    @elseif($diagnostico->estado == 'en_proceso') bg-info 
                    @else bg-success @endif">
                    {{ ucfirst($diagnostico->estado) }}
                </span>
            </div>

            @if($diagnostico->solucion)
                <div class="mb-3">
                    <strong>Respuesta del tutorado:</strong>
                    <p class="border p-2 bg-light">{{ $diagnostico->solucion }}</p>
                </div>
            @endif

            @can('update', $diagnostico)
                {{-- Formulario para que el tutorado conteste --}}
                @if(Auth::user()->role->nombre === 'tutorado')
                    <div class="card mt-4">
                        <div class="card-header bg-success text-white">
                            <h4><i class="fas fa-pen"></i> Contestar Diagnóstico</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('diagnosticos.responder', $diagnostico) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="solucion" class="form-label">Tu respuesta o solución</label>
                                    <textarea name="solucion" id="solucion" class="form-control" rows="4" placeholder="Escribe tu respuesta..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Enviar Respuesta
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endcan

            <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
@stop
