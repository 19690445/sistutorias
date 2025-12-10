@extends('adminlte::page')

@section('title', 'Detalles de Canalización')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-project-diagram"></i>
            Detalles de Canalización
        </h1>
        <div>
            <a href="{{ route('canalizaciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            @can('edit', $canalizacione)
                <a href="{{ route('canalizaciones.edit', $canalizacione) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye"></i>
                        Información de la Canalización
                        <span class="badge badge-{{ $canalizacione->estado_color }} ml-2">
                            {{ ucfirst($canalizacione->estado) }}
                        </span>
                    </h3>
                </div>

                <div class="card-body">
                    <!-- Información del Estudiante y Tutor -->
                    <div class="row border-bottom mb-3 pb-3">
                        <div class="col-md-6">
                            <h5 class="text-primary">
                                <i class="fas fa-user-graduate mr-2"></i>INFORMACIÓN DEL ESTUDIANTE
                            </h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Estudiante:</th>
                                    <td>{{ $canalizacione->individual->estudiante->nombre ?? 'N/A' }} {{ $canalizacione->individual->estudiante->apellido ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Matrícula:</th>
                                    <td>{{ $canalizacione->individual->estudiante->matricula ?? 'N/A' }}</td>
                                </tr>
                                <tr>
    <th>Carrera:</th>
    <td>
        {{ $canalizacione->individual->estudiante->carrera ?? 'N/A' }}
    </td>
</tr>
                                <tr>
                                    <th>Semestre:</th>
                                    <td>{{ $canalizacione->individual->estudiante->semestre ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="text-primary">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>INFORMACIÓN DEL TUTOR
                            </h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Tutor:</th>
                                    <td>{{ $canalizacione->individual->tutor->nombre ?? 'N/A' }} {{ $canalizacione->individual->tutor->apellido ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Departamento:</th>
                                    <td>{{ $canalizacione->individual->tutor->departamento ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Período:</th>
                                    <td>{{ $canalizacione->individual->periodo->nombre ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha creación:</th>
                                    <td>{{ $canalizacione->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Tipo de Atención -->
                    <div class="row border-bottom mb-3 pb-3">
                        <div class="col-12">
                            <h5 class="text-primary">
                                <i class="fas fa-headset mr-2"></i>TIPO DE ATENCIÓN
                            </h5>
                            <div class="form-group">
                                <label>Tipo de atención requerida:</label>
                                <p class="form-control-plaintext border rounded p-2 bg-light">
                                    {{ $canalizacione->tipo_atencion }}
                                    @if($canalizacione->tipo_atencion == 'Otros (especifique)' && $canalizacione->causa_problema)
                                        <br><small class="text-muted">Especificación: {{ $canalizacione->causa_problema }}</small>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Caso -->
                    <div class="row border-bottom mb-3 pb-3">
                        <div class="col-12">
                            <h5 class="text-primary">
                                <i class="fas fa-exclamation-triangle mr-2"></i>DETALLES DEL CASO
                            </h5>
                            <div class="form-group">
                                <label>Descripción del problema:</label>
                                <div class="border rounded p-3 bg-light" style="min-height: 100px;">
                                    {!! nl2br(e($canalizacione->causa_problema_general)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones y Planificación -->
                    <div class="row border-bottom mb-3 pb-3">
                        <div class="col-12">
                            <h5 class="text-primary">
                                <i class="fas fa-tasks mr-2"></i>ACCIÓN Y PLANIFICACIÓN
                            </h5>
                            <div class="form-group">
                                <label>Acciones sugeridas:</label>
                                <div class="border rounded p-3 bg-light" style="min-height: 100px;">
                                    {!! nl2br(e($canalizacione->acciones_sugeridas)) !!}
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha propuesta para primera sesión:</label>
                                        <p class="form-control-plaintext border rounded p-2 bg-light">
                                            {{ $canalizacione->primera_sesion_propuesta ? \Carbon\Carbon::parse($canalizacione->primera_sesion_propuesta)->format('d/m/Y') : 'No especificada' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha real de sesión inicial:</label>
                                        <p class="form-control-plaintext border rounded p-2 bg-light">
                                            {{ $canalizacione->primera_sesion_real ? \Carbon\Carbon::parse($canalizacione->primera_sesion_real)->format('d/m/Y') : 'No realizada' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seguimiento y Estado -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-primary">
                                <i class="fas fa-chart-line mr-2"></i>SEGUIMIENTO Y EVALUACIÓN
                            </h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Seguimiento del tutor:</label>
                                <div class="border rounded p-3 bg-light" style="min-height: 100px;">
                                    {!! nl2br(e($canalizacione->seguimiento_tutor)) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado de la canalización:</label>
                                <p class="form-control-plaintext border rounded p-2 bg-light">
                                    <span class="badge badge-{{ $canalizacione->estado_color }}">
                                        {{ ucfirst($canalizacione->estado) }}
                                    </span>
                                </p>
                                
                                <div class="form-group mt-3">
                                    <label>Observaciones generales:</label>
                                    <div class="border rounded p-3 bg-light" style="min-height: 100px;">
                                        {!! nl2br(e($canalizacione->observaciones)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie de tarjeta con acciones -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-4">
                            @can('edit', $canalizacione)
                                <a href="{{ route('canalizaciones.edit', $canalizacione) }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            @else
                                <button class="btn btn-secondary btn-block" disabled>
                                    <i class="fas fa-eye"></i> Solo Lectura
                                </button>
                            @endcan
                        </div>
                        <div class="col-md-4">
                            @can('delete', $canalizacione)
                                <form action="{{ route('canalizaciones.destroy', $canalizacione) }}" method="POST" 
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-block" disabled>
                                    <i class="fas fa-trash"></i> No permitido
                                </button>
                            @endcan
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('canalizaciones.index') }}" class="btn btn-default btn-block">
                                <i class="fas fa-list"></i> Ver Todas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .border-bottom {
            border-bottom: 2px solid #dee2e6 !important;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .text-primary {
            color: #764ba2 !important;
        }
        .badge-pendiente {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-en_proceso {
            background-color: #17a2b8;
            color: white;
        }
        .badge-finalizado {
            background-color: #28a745;
            color: white;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Confirmación para eliminar
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar canalización?',
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop