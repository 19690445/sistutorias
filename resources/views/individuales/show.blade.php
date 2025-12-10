@extends('adminlte::page')

@section('title', 'Detalles del Registro')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-user-circle"></i>
            Detalles del Registro Individual
        </h1>
        <div>
            <a href="{{ route('individuales.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('individuales.edit', $individuale) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-graduate"></i>
                        Información del Estudiante
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $individuale->estudiante->nombre ?? 'N/A' }} {{ $individuale->estudiante->apellido ?? '' }}</dd>
                        
                        <dt class="col-sm-4">Matrícula:</dt>
                        <dd class="col-sm-8">{{ $individuale->estudiante->matricula ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Carrera:</dt>
                        <dd class="col-sm-8">{{ $individuale->estudiante->carrera ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $individuale->estudiante->email ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>
            
            
            <div class="card card-info mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Información del Tutor
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $individuale->tutor->nombre ?? 'N/A' }} {{ $individuale->tutor->apellido ?? '' }}</dd>
                        
                        <dt class="col-sm-4">Especialidad:</dt>
                        <dd class="col-sm-8">{{ $individuale->tutor->especialidad ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $individuale->tutor->email ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
          
            <div class="card">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-clipboard-list"></i>
                        Detalles del Registro
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Período Académico</span>
                                    <span class="info-box-number">
                                        {{ $individuale->periodo->nombre ?? 'N/A' }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $individuale->periodo->fecha_inicio ?? '' }} - {{ $individuale->periodo->fecha_fin ?? '' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon {{ $individuale->requiere_canalizacion == 'si' ? 'bg-danger' : 'bg-success' }}">
                                    <i class="fas fa-project-diagram"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Canalización</span>
                                    <span class="info-box-number">
                                        @if($individuale->requiere_canalizacion == 'si')
                                            REQUERIDA
                                        @else
                                            NO REQUERIDA
                                        @endif
                                    </span>
                                    <small class="text-muted">
                                        @if($individuale->requiere_canalizacion == 'si' && $individuale->estado != 'completado')
                                            <a href="{{ route('canalizaciones.create') }}?individual_id={{ $individuale->id }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-plus"></i> Crear Canalización
                                            </a>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado del Proceso</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            @if($individuale->estado == 'pendiente')
                                                <i class="fas fa-clock text-warning"></i>
                                            @elseif($individuale->estado == 'en_proceso')
                                                <i class="fas fa-spinner text-primary"></i>
                                            @else
                                                <i class="fas fa-check-circle text-success"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ ucfirst($individuale->estado) }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de Creación</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" 
                                           value="{{ $individuale->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Motivo u Observaciones</label>
                        <textarea class="form-control" rows="3" readonly>{{ $individuale->motivo }}</textarea>
                    </div>
                    
                  
                    @if($individuale->canalizaciones->count() > 0)
                        <div class="mt-4">
                            <h5><i class="fas fa-project-diagram"></i> Canalizaciones Asociadas</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo Atención</th>
                                            <th>Estado</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($individuale->canalizaciones as $canalizacion)
                                            <tr>
                                                <td>{{ $canalizacion->id }}</td>
                                                <td>{{ $canalizacion->tipo_atencion }}</td>
                                                <td>
                                                    @if($canalizacion->estado == 'pendiente')
                                                        <span class="badge badge-warning">Pendiente</span>
                                                    @elseif($canalizacion->estado == 'en_proceso')
                                                        <span class="badge badge-primary">En Proceso</span>
                                                    @else
                                                        <span class="badge badge-success">Finalizado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($canalizacion->primera_sesion_propuesta)
                                                        {{ \Carbon\Carbon::parse($canalizacion->primera_sesion_propuesta)->format('d/m/Y') }}
                                                    @else
                                                        <span class="text-muted">No programada</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('canalizaciones.show', $canalizacion) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @elseif($individuale->requiere_canalizacion == 'si' && $individuale->estado != 'completado')
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle"></i>
                            Este registro requiere canalización pero aún no se ha creado ninguna.
                            <a href="{{ route('canalizaciones.create') }}?individual_id={{ $individuale->id }}" 
                               class="btn btn-sm btn-primary float-right">
                                <i class="fas fa-plus"></i> Crear Canalización
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .info-box {
            margin-bottom: 0;
        }
        .info-box .info-box-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        dt {
            font-weight: 600;
        }
        .badge {
            font-size: 0.9em;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            
        });
    </script>
@stop