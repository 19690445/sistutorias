@extends('adminlte::page')

@section('title', 'Malla de Asistencia - ' . ($grupo->nombre_grupo ?? 'Grupo'))

@section('content_header')
    <h1>Malla de Asistencia{{ $grupo->nombre_grupo ?? 'Grupo' }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="card-title">Estudiantes del Grupo: <strong>{{ $grupo->nombre_grupo ?? 'N/A' }}</strong></h3>
                    @if($grupo->descripcion)
                        <p class="mb-0 text-white">{{ $grupo->descripcion }}</p>
                    @endif
                </div>
                <div class="col-md-4 text-right">
                    <div class="btn-group">
                        <a href="{{ route('asistencias.create') }}" class="btn btn-light">
                            <i class="fas fa-plus"></i> Nueva Asistencia
                        </a>
                        <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-md-4">
                        <h6><i class="fas fa-users"></i> Información del Grupo</h6>
                        <p class="mb-1"><strong>Grupo:</strong> {{ $grupo->nombre_grupo ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Estudiantes:</strong> {{ $estudiantes->count() }}</p>
                        @if($grupo->capacidad)
                            <p class="mb-0"><strong>Capacidad:</strong> {{ $estudiantes->count() }}/{{ $grupo->capacidad }}</p>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h6><i class="fas fa-chart-line"></i> Estadísticas del Grupo</h6>
                        @php
                            $totalAsistenciasGrupo = 0;
                            $totalPresentesGrupo = 0;
                            
                            foreach($estudiantes as $estudiante) {
                                $totalAsistenciasGrupo += $estudiante->asistencias_count ?? 0;
                                $totalPresentesGrupo += $estudiante->presentes_count ?? 0;
                            }
                            
                            $porcentajeGrupo = $totalAsistenciasGrupo > 0 
                                ? round(($totalPresentesGrupo / $totalAsistenciasGrupo) * 100, 1) 
                                : 0;
                        @endphp
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Total Asistencias:</strong> {{ $totalAsistenciasGrupo }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Total Presentes:</strong> {{ $totalPresentesGrupo }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0"><strong>Promedio Grupo:</strong> {{ $porcentajeGrupo }}%</p>
                            </div>
                        </div>
                        <div class="progress mt-2" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: {{ $porcentajeGrupo }}%">
                                {{ $porcentajeGrupo }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($estudiantes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Estudiante</th>
                                <th width="20%">Contacto</th>
                                <th width="30%">Asistencia</th>
                                <th width="20%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $index => $estudiante)
                            @php
                                $totalAsistencias = $estudiante->asistencias->count();
                                $presentes = $estudiante->asistencias->where('estado', 'si')->count();
                                $ausentes = $estudiante->asistencias->where('estado', 'no')->count();
                                $justificados = $estudiante->asistencias->where('estado', 'justificado')->count();
                                $noProgramados = $estudiante->asistencias->where('estado', 'np')->count();
                                
                                $porcentaje = $totalAsistencias > 0 
                                    ? round(($presentes / $totalAsistencias) * 100, 1) 
                                    : 0;
                                
                                
                                $barColor = 'bg-success'; //Verde 
                                if ($porcentaje < 50) {
                                    $barColor = 'bg-danger'; //Rojo
                                } elseif ($porcentaje < 75) {
                                    $barColor = 'bg-warning'; //Amarillo
                                }
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</strong>
                                    @if($estudiante->matricula)
                                        <br><small class="text-muted">Matrícula: {{ $estudiante->matricula }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($estudiante->correo_institucional)
                                        <i class="fas fa-envelope text-primary"></i> 
                                        <a href="mailto:{{ $estudiante->correo_institucional }}">{{ $estudiante->correo_institucional }}</a>
                                    @else
                                        <span class="text-muted">Sin email</span>
                                    @endif
                                    @if($estudiante->telefono)
                                        <br><i class="fas fa-phone text-success"></i> {{ $estudiante->telefono }}
                                    @endif
                                </td>
                                <td>
                                    @if($totalAsistencias > 0)
                                        <div class="mb-2">
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar {{ $barColor }}" role="progressbar" 
                                                     style="width: {{ $porcentaje }}%" 
                                                     aria-valuenow="{{ $porcentaje }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <strong>{{ $presentes }}/{{ $totalAsistencias }} ({{ $porcentaje }}%)</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-3">
                                                <span class="badge badge-success">{{ $presentes }} P</span>
                                            </div>
                                            <div class="col-3">
                                                <span class="badge badge-danger">{{ $ausentes }} A</span>
                                            </div>
                                            <div class="col-3">
                                                <span class="badge badge-info">{{ $justificados }} J</span>
                                            </div>
                                            <div class="col-3">
                                                <span class="badge badge-warning">{{ $noProgramados }} NP</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-light text-center mb-0">
                                            <i class="fas fa-info-circle"></i> Sin registros de asistencia
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info" 
                                                onclick="verHistorial({{ $estudiante->id }})"
                                                title="Ver Historial">
                                            <i class="fas fa-history"></i> Historial
                                        </button>
                                        <a href="#" class="btn btn-warning"
                                           title="Registrar Asistencia Individual">
                                            <i class="fas fa-user-check"></i> Asistencia
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-secondary mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-chart-pie"></i> Resumen General</h6>
                            <p class="mb-1"><strong>Total Estudiantes:</strong> {{ $estudiantes->count() }}</p>
                            <p class="mb-1"><strong>Asistencias Registradas:</strong> {{ $totalAsistenciasGrupo }}</p>
                            <p class="mb-0"><strong>Promedio de Asistencia:</strong> {{ $porcentajeGrupo }}%</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success" onclick="imprimirTabla()">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </div>
                    </div>
                </div>
                
            @else
                <div class="alert alert-warning text-center">
                    <h5><i class="fas fa-exclamation-triangle fa-2x mb-3"></i></h5>
                    <h4>No hay estudiantes inscritos en este grupo</h4>
                    <p class="mb-3">Agrega estudiantes al grupo para comenzar a registrar asistencias.</p>
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Agregar Estudiantes
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para historial -->
    <div class="modal fade" id="historialModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Historial de Asistencias</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="historialContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando</span>
                            </div>
                            <p class="mt-2">Cargando historial</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .progress {
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-bar {
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table th {
        vertical-align: middle;
        text-align: center;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
</style>
@stop

@section('js')
<script>
    function verHistorial(estudianteId) {
        $('#historialContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p class="mt-2">Cargando historial</p>
            </div>
        `);
        
        $('#historialModal').modal('show');
        
        $.ajax({
            url: "{{ url('asistencias/historial') }}/" + estudianteId,
            method: 'GET',
            success: function(response) {
                $('#historialContent').html(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                $('#historialContent').html(`
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-triangle"></i> Error</h5>
                        <p>No se pudo cargar el historial de asistencias.</p>
                        <p><small>Código: ${xhr.status} - ${xhr.statusText}</small></p>
                    </div>
                `);
            }
        });
    }
    
    function imprimirTabla() {
        window.print();
    }
    
    // Auto-refrescar la página cada 60 segundos para ver datos actualizados
    setTimeout(function() {
        location.reload();
    }, 60000);
    
    $(document).ready(function() {
        // Tooltips
        $('[title]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
        
    });
</script>
@stop